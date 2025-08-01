<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		// if (!isset($this->session->userdata['id_user'])) {
		// redirect(base_url("login"));
		// }
		// if ($this->session->userdata("level") <> 1) {
		// redirect(base_url("Dashboard"));
		// }

		$this->load->library('upload');
		$this->load->model('Model_Karyawan', 'karyawan');
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

	//Karyawan	
	public function tampil()
	{

		$this->session->set_userdata("judul", "Data Master");
		$ba = [
			'judul' => "Data Master",
			'subjudul' => "Karyawan",
		];
		// $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
		$d = [];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('karyawan', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_karyawan()
	{
		$list = $this->karyawan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $karyawan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $karyawan->kry_nama;
			$row[] = $karyawan->kry_jk == 1 ? "Laki-laki" : "Perempuan";
			$row[] = $karyawan->kry_telp;
			$row[] = $karyawan->kry_wa;
			$row[] = $karyawan->kry_alamat;
			$row[] = "<a href='#' onClick='ubah_karyawan(" . $karyawan->kry_id . ")' class='btn btn-info btn-sm mr-3' title='Ubah data Karyawan'><i class='fas fa-edit'></i></a><a href='#' onClick='hapus_karyawan(" . $karyawan->kry_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data Karyawan'><i class='fas fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->karyawan->count_all(),
			"recordsFiltered" => $this->karyawan->count_filtered(),
			"data" => $data,
			"query" => $this->karyawan->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('kry_id');
		$data = $this->karyawan->cari_karyawan($id);
		echo json_encode($data);
	}

	public function caribywa()
	{
		$wa = $this->input->post('kry_telp');
		$data = $this->karyawan->cari_karyawan_bywa($wa);
		if ($data) {
			$sumber = explode(";", $data->kry_sumber);
			$data->kry_sumber = $sumber;
		}
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('kry_id');
		$data = $this->input->post();
		$tgl = explode("/", $data['kry_tgl_lahir']);
		$data['kry_tgl_lahir'] = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";

		if ($id == 0) {
			$insert = $this->karyawan->simpan("ktk_karyawan", $data);
		} else {
			$insert = $this->karyawan->update("ktk_karyawan", array('kry_id' => $id), $data);
		}
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			if ($id == 0) {
				$resp['status'] = 0;
				$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
				$resp['error'] = $err;
			} else {
				$resp['status'] = 1;
				$resp['desc'] = "Berhasil menyimpan data";
			}
		}
		echo json_encode($resp);
	}


	public function hapus($id)
	{
		$delete = $this->karyawan->delete('ktk_karyawan', 'kry_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menghapus data";
		}
		echo json_encode($resp);
	}
}
