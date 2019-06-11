<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function select2mahasiswa() {
		$q = $this->input->post_get('q');
		$start = (int) $this->input->post_get('page');
		$start = $start ? $start - 1 : 0;
		$limit = 10;

		$count = $this->mahasiswa_count($q);
		$data = $this->mahasiswa_data($start, $limit, $q);

		$options = [];
		foreach($data as $row) {
			$options[] = ['id' => $row->id, 'text' => $row->nama];
		}

		exit(json_encode(['items' => $options, 'total_count' => $count]));
	}

	private function mahasiswa_count($q = null) {
		return $this->db->like('nama', $q)->get('mahasiswa')->num_rows();
	}

	private function mahasiswa_data($start = 0, $limit = 10, $q = null) {
		$start = $start * $limit;
		return $this->db
				->offset($start)
				->limit($limit)
				->like('nama', $q)
				->get('mahasiswa')
				->result();
	}
}
