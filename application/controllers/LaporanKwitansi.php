<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanKwitansi extends CI_Controller
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
        $this->load->model('Model_LaporanKwitansi', 'lapkwitansi');
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

    //kwitansi	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Laporan Kwitansi",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'karyawan' => $this->karyawan->get_karyawan(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('laporan_kwitansi', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_laporan($tgl1, $tgl2)
    {
        $list = $this->lapkwitansi->get_datatables($tgl1, $tgl2);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $laporan) {
            $no++;

            $terpakai = $this->lapkwitansi->get_terpakai($laporan->pkw_kry_id);
            $sisa = $laporan->pkw_jml - $terpakai;

            $row = array();
            $row[] = $no;
            $row[] = $laporan->kry_nama;
            $row[] = $laporan->pkw_jml;
            $row[] = $terpakai;
            $row[] = $sisa;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lapkwitansi->count_all(),
            "recordsFiltered" => $this->lapkwitansi->count_filtered($tgl1, $tgl2),
            "data" => $data,
            "query" => $this->lapkwitansi->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }
}
