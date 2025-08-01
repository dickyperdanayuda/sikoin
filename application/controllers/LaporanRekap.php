<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanRekap extends CI_Controller
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
        $this->load->model('Model_Rekap', 'rekap');
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
            'subjudul' => "Laporan Rekap",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'dijemput' => $this->rekap->get_dijemput(),
            'dihitung' => $this->rekap->get_dihitung(),
            'blm_dihitung' => $this->rekap->get_blm_dihitung(),
            'uang_dihitung' => $this->rekap->get_uang_dihitung(),
            'divalidasi' => $this->rekap->get_divalidasi(),
            'blm_divalidasi' => $this->rekap->get_blm_divalidasi(),
            'uang_divalidasi' => $this->rekap->get_uang_divalidasi(),
            'uang_blm_divalidasi' => $this->rekap->get_uang_blm_divalidasi(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('laporan_rekap', $d);
        $this->load->view('background_bawah');
    }

    function cari_rekap($tgl1, $tgl2)
    {
        $totaljemput = 0;
        $totalhitung = 0;
        $totalblmhitung = 0;
        $totaljmluang = 0;
        $totalvalidasi = 0;
        $totaluangvalidasi = 0;
        $totalblmvalidasi = 0;
        $totaluangblmvalidasi = 0;
        $ambil = $this->rekap->get_rekap($tgl1, $tgl2);
        foreach ($ambil as $abl) {
            $totaljemput++;
            if ($abl->jpt_user_hitung > 0) {
                $totalhitung++;
                $totaljmluang += $abl->jpt_jml_pecahan;
            }
            if ($abl->jpt_user_validasi > 0) {
                $totalvalidasi++;
                $totaluangvalidasi += $abl->jpt_jml_pecahan;
            }
        }
        $totalblmhitung  = $totaljemput - $totalhitung;
        $totalblmvalidasi = $totalhitung - $totalvalidasi;
        $totaluangblmvalidasi = $totaljmluang - $totaluangvalidasi;

        $data = array(
            'totaljpt' => $totaljemput,
            'totalhtg' => $totalhitung,
            'totalblmhtg' => $totalblmhitung,
            'totaljmluang' => $totaljmluang,
            'totalvalid' => $totalvalidasi,
            'totaluangvalid' => $totaluangvalidasi,
            'totalblmvalid' => $totalblmvalidasi,
            'totaluangblmvalid' => $totaluangblmvalidasi,
        );
        echo json_encode($data);
    }
}
