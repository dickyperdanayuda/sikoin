<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanHitung extends CI_Controller
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
        $this->load->model('Model_Laporan', 'laporan');
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

    //Pembelian	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Laporan Hitung",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('laporan_hitung', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_laporan($tgl1, $tgl2)
    {
        $list = $this->laporan->get_datatables($tgl1, $tgl2);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $laporan) {
            $no++;
            if ($laporan->jpt_tgl_hitung != null) {
                $row = array();
                $row[] = $no;
                $row[] = $laporan->jpt_tgl_hitung;
                $row[] = $laporan->jpt_user_hitung;
                $row[] = $laporan->don_nama;
                $row[] = $laporan->kot_nomor;
                $row[] = $laporan->jpt_kw_nomor;
                $row[] = $laporan->jpt_jml_pecahan;
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan->count_all(),
            "recordsFiltered" => $this->laporan->count_filtered($tgl1, $tgl2),
            "data" => $data,
            "query" => $this->laporan->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }
}
