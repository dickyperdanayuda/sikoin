<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
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
        $this->load->model('Model_History', 'history');
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
            'subjudul' => "History",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'history' => $this->history->get_history(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('history', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_history($tgl1, $tgl2)
    {
        $list = $this->history->get_datatables($tgl1, $tgl2);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $history) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $this->history->tanggal($history->his_tgl);
            if ($history->his_jenis == 1) {
                $row[] = "Kotak Masuk";
            } elseif ($history->his_jenis == 2) {
                $row[] = "Kotak Keluar";
            }
            $row[] = $history->jml;
            $row[] = $history->his_stok;
            $row[] = $history->his_ket;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->history->count_all(),
            "recordsFiltered" => $this->history->count_filtered($tgl1, $tgl2),
            "data" => $data,
            "query" => $this->history->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }
}
