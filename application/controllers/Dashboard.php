<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_Dashboard', 'dashboard');
		date_default_timezone_set('Asia/Jakarta');
	}

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
		redirect(base_url("Dashboard/tampil"));
	}
	public function tampil()
	{
		$userr = $this->session->userdata('log_kry');
		$ba = [
			'judul' => "Dashboard",
			'subjudul' => "",
		];

		$d = [
			'donatur' => $this->dashboard->get_donatur(),
			'kotak' => $this->dashboard->get_kotak(),
			'kotakkeluar' => $this->dashboard->get_kotakkeluar(),
			'penugasan' => $this->dashboard->get_penugasan($userr),
			'kwitansi' => $this->dashboard->get_kwitansi($userr),
		];

		$this->load->view('background_atas', $ba);
		$this->load->view('dashboard', $d);
		$this->load->view('background_bawah');
	}

	public function notif()
	{
		$ntf = $this->dashboard->get_pesanan();
		echo $ntf;
	}

	public function notif_detail()
	{
		$ntf = $this->dashboard->get_pesanan();
		$notif = $this->dashboard->get_pesanan_detail();
		$d = [
			'jml_pesan' => $ntf,
			'pesanan' => $notif,
		];
		$this->load->view("notif", $d);
	}

	public function ajax_list_dashboard($tgl1 = null, $tgl2 = null)
	{

		$list = $this->dashboard->get_datatables($tgl1, $tgl2);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dashboard) {
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = $dashboard->prd_nama;
			$row[] = $this->dashboard->uang($dashboard->pjd_jml, 0);
			$row[] = $this->dashboard->uang($dashboard->pjd_profit, 0);
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->dashboard->count_all($tgl1, $tgl2),
			"recordsFiltered" => $this->dashboard->count_filtered($tgl1, $tgl2),
			"data" => $data,
			"query" => $this->dashboard->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}
}
