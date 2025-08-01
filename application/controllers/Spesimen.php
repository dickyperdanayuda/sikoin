<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spesimen extends CI_Controller
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
		$this->load->model('Model_Spesimen', 'spesimen');
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
			'subjudul' => "Spesimen",
		];
		// $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
		$d = [
			'karyawan' => $this->karyawan->get_karyawan(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('spesimen', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_spesimen()
	{
		$list = $this->spesimen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $spesimen) {
			$no++;
			$foto = "<div style='background-image:url(\"".base_url('assets/dist/img/no-image.jpg?').microtime(true)."\");background-position:center;background-repeat:no-repeat;background-size:contain;height:80px;width:80px;'></div>";
			
			if ($spesimen->sps_foto) $foto = "<div style='background-image:url(\"".base_url('assets/files/spesimen/thumbs/'.$spesimen->sps_foto.'?'.microtime(true))."\");background-position:center;background-repeat:no-repeat;background-size:contain;height:80px;width:80px;'></div>";

			$row = array();
			$row[] = $no;
			$row[] = $spesimen->kry_nama;
			$row[] = $spesimen->sps_nama;
			$row[] = $foto;
			$row[] = "<a href='#' onClick='hapus_spesimen(" . $spesimen->sps_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data spesimen'><i class='fas fa-trash'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->spesimen->count_all(),
			"recordsFiltered" => $this->spesimen->count_filtered(),
			"data" => $data,
			"query" => $this->spesimen->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('sps_id');
		$data = $this->spesimen->cari_spesimen($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('sps_id');
		$data = $this->input->post();

		$nama = str_replace(' ', '-', trim($data['sps_nama']));
		if (!empty($_FILES['file_foto']['name'])) {
			if (!is_dir('assets/files/spesimen')) {
				mkdir('assets/files/spesimen', 0777, TRUE);
			}
			if (!is_dir('assets/files/spesimen/thumbs')) {
				mkdir('assets/files/spesimen/thumbs', 0777, TRUE);
			}
			$path = $_FILES['file_foto']['name'];
			$ext =  pathinfo($path, PATHINFO_EXTENSION);
			$config['upload_path'] = 'assets/files/spesimen/'; //path folder
			$config['allowed_types'] = '*'; //type yang dapat diakses bisa anda sesuaikan
			$config['encrypt_name'] = FALSE; //Enkripsi nama yang terupload
			$config['overwrite'] = TRUE; //Gantikan file dengan nama yang sama
			$config['file_name'] = "{$nama}." . $ext; //ganti nama file

			$this->upload->initialize($config);
		}

		if (!empty($_FILES['file_foto']['name'])) {

			if ($this->upload->do_upload('file_foto')) {
				$foto = $this->upload->data();

				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/files/spesimen/' . $foto['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['quality'] = '50%';
				$config['width'] = 150;
				$config['height'] = 150;
				$config['new_image'] = 'assets/files/spesimen/thumbs/' . $foto['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$data['sps_foto'] = $foto['file_name'];
			}
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($id == 0) {
			$insert = $this->spesimen->simpan("ktk_spesimen", $data);
		} else {
			$insert = $this->spesimen->update("ktk_spesimen", array('sps_id' => $id), $data);
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
		$delete = $this->spesimen->delete('ktk_spesimen', 'sps_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menghapus data";
		}
		echo json_encode($resp);
	}
}
