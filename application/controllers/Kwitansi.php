<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kwitansi extends CI_Controller
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
        $this->load->model('Model_Penjemputan', 'penjemputan');
        $this->load->model('Model_Kwitansi', 'kwitansi');
        $this->load->model('Model_Donatur', 'donatur');
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

    //kwitansi	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Kwitansi",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'donatur' => $this->donatur->get_donatur(),
            'karyawan' => $this->karyawan->get_karyawan(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('kwitansi', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_kwitansi()
    {
        $list = $this->penjemputan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $penjemputan) {
            $no++;
            if (($penjemputan->jpt_tgl_hitung != null) && ($penjemputan->jpt_kwitansi == null)) {
                $row = array();
                $row[] = $no;
                $row[] = $penjemputan->jpt_tgl_hitung;
                $row[] = $penjemputan->don_nama;
                $row[] = $penjemputan->kot_nomor;
                $row[] = $penjemputan->jpt_jml_pecahan;
                $row[] = "<a href='" . base_url('Kwitansi/buat_kwitansi/' . $penjemputan->jpt_id) . "' class='btn btn-info btn-sm mr-3' title='Buat Kwitansi'>Buat Kwitansi</a>";
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->penjemputan->count_all(),
            "recordsFiltered" => $this->penjemputan->count_filtered(),
            "data" => $data,
            "query" => $this->penjemputan->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }

    public function buat_kwitansi($id)
    {
        $data = $this->penjemputan->get_penjemputan2($id);
        $pengumpulan2 = $this->penjemputan->cari_pecahan2($id);
        $penyetor = $this->penjemputan->cari_penyetor($data->jpt_user_jemput);
        $penerima = $this->penjemputan->cari_penerima($data->jpt_user_hitung);
        $jml = 0;
        $datapecahan = array();
        foreach ($pengumpulan2 as $pcu) {
            if (!isset($datapecahan[$pcu->pcg_nilai])) $datapecahan[$pcu->pcg_nilai] = 0;
            $datapecahan[$pcu->pcg_nilai] += $pcu->pcg_jml;
            $jml = $data->jpt_jml_pecahan;
        }

        $d = [
            'jpt_id' => $id,
            'jpt_kw_nomor' => $data->jpt_kw_nomor,
            'jpt_tgl_jemput' => $data->jpt_tgl_jemput,
            'don_nama' => $data->don_nama,
            'don_wa' => $data->kd_wa,
            'jml' => $jml,
            'arrPecahan' => $datapecahan,
            'penyetor' => $penyetor,
            'penerima' => $penerima,
        ];
        $this->load->view('buat_kwitansi', $d);
    }

    public function simpan_kwitansi()
    {
        $id = $this->input->post('jpt_id');
        $nama = "file";
        $foto = explode(",", $this->input->post('foto'));
        $image = base64_decode($foto[1]);
        $filename = $id . "-" . str_replace(" ", "-", $nama) . ".png";
        if (!is_dir('assets/images/kwitansi')) {
            mkdir('assets/images/kwitansi', 0777, TRUE);
        }
        $path = "assets/images/kwitansi/";
        $data = [
            "jpt_kwitansi" => $filename,
        ];
        $insert = $this->penjemputan->update("ktk_penjemputan", array('jpt_id' => $id), $data);
        if ($insert) {
            file_put_contents($path . $filename, $image);
        }
        echo $insert;
    }
}
