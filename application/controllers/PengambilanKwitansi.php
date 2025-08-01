<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengambilanKwitansi extends CI_Controller
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
        $this->load->model('Model_PengambilanKwitansi', 'ambilkwitansi');
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

    //pengambilan_kwitansi	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Pengambilan Kwitansi",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'karyawan' => $this->karyawan->get_karyawan(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('pengambilan_kwitansi', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_ambilkwitansi()
    {
        $list = $this->ambilkwitansi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ambilkwitansi) {
            $awal = $ambilkwitansi->pkw_awal;
            $akhir = $ambilkwitansi->pkw_akhir;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ambilkwitansi->kry_nama;
            $row[] = $this->ambilkwitansi->tanggal($ambilkwitansi->pkw_tgl);
            $row[] = $awal . ' - ' . $akhir;
            $row[] = $ambilkwitansi->pkw_jml;
            $row[] = "<a href='#' onClick='ubah_kwitansi({$ambilkwitansi->pkw_id})' class='btn btn-info btn-sm mr-3' title='Ubah Kwitansi'><i class='fas fa-edit'></i></a><a href='#' onClick='hapus_kwitansi({$ambilkwitansi->pkw_id})' class='btn btn-danger btn-sm mr-3 title='hapus kwitansi'><i class='fas fa-trash-alt'></i></a>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ambilkwitansi->count_all(),
            "recordsFiltered" => $this->ambilkwitansi->count_filtered(),
            "data" => $data,
            "query" => $this->ambilkwitansi->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari()
    {
        $id = $this->input->post('pkw_id');
        $data = $this->ambilkwitansi->cari_pengambilan_kwitansi($id);
        echo json_encode($data);
    }

    public function simpan()
    {
        $awal = $this->input->post('pkw_awal');
        $akhir = $this->input->post('pkw_akhir');
        $range = range($awal, $akhir);
        $jumlah = count($range);

        $id = $this->input->post('pkw_id');
        $data = $this->input->post();
        $tgl = explode("/", $data['pkw_tgl']);
        $data['pkw_tgl'] = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";
        $data = [
            'pkw_kry_id' => $data['pkw_kry_id'],
            'pkw_tgl' => $data['pkw_tgl'],
            'pkw_awal' => $data['pkw_awal'],
            'pkw_akhir' => $data['pkw_akhir'],
            'pkw_jml' => $jumlah,
            'pkw_waktu_entry' => date('Y-m-d H:i:s'),
            'pkw_user_entry' => $this->session->userdata('id_user'),
        ];

        $error = $this->db->error();
        if (!empty($error)) {
            $err = $error['message'];
        } else {
            $err = "";
        }
        if ($id == 0) {
            $insert = $this->ambilkwitansi->simpan("ktk_pengambilan_kwitansi", $data);
        } else {
            $insert = $this->ambilkwitansi->update("ktk_pengambilan_kwitansi", array('pkw_id' => $id), $data);
        }
        if ($insert) {
            $idkw = $insert;
            if ($id > 0) $idkw = $id;
            $this->ambilkwitansi->delete('ktk_kwitansi', 'kw_pkw_id', $idkw);
            for ($nk = $data['pkw_awal']; $nk <= $data['pkw_akhir']; $nk++) {
                $data1 = [
                    'kw_pkw_id' => $insert,
                    'kw_nomor' => $nk,
                    'kw_pemegang' => $data['pkw_kry_id'],
                    'kw_status' => 0,
                ];
                $this->ambilkwitansi->simpan("ktk_kwitansi", $data1);
            }
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
        $delete = $this->ambilkwitansi->delete('ktk_pengambilan_kwitansi', 'pkw_id', $id);
        if ($delete) {
            $delete = $this->ambilkwitansi->delete('ktk_kwitansi', 'kw_pkw_id', $id);
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }
}
