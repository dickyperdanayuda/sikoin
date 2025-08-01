<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KotakKeluar extends CI_Controller
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
        $this->load->model('Model_KotakKeluar', 'kotakkeluar');
        $this->load->model('Model_Donatur', 'donatur');
        $this->load->model('Model_Karyawan', 'karyawan');
        $this->load->model('Model_Kotak', 'kotak');
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

    //kotakkeluar	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Kotak Keluar",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'kotakkeluar' => $this->kotakkeluar->get_kotakkeluar(),
            'karyawan' => $this->karyawan->get_karyawan(),
            'donatur' => $this->donatur->get_donatur(),
            'kotak' => $this->kotak->get_nomorkotak(),
            'kotaks' => $this->kotakkeluar->get_kotaks(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('kotak_keluar', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_kotak($tgl1 = null, $tgl2 = null, $kotno = null)
    {
        $list = $this->kotakkeluar->get_datatables($tgl1, $tgl2, $kotno);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kotakkeluar) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date("d-m-Y",strtotime($kotakkeluar->kel_tgl));
            $row[] = $kotakkeluar->don_nama;
            $row[] = $kotakkeluar->kry_nama;
            $row[] = $kotakkeluar->kel_kot_nomor;
            $row[] = $kotakkeluar->don_alamat;
            $row[] = $kotakkeluar->kel_ket;
            $row[] = "<a href='#' onClick='hapus_kotak(" . $kotakkeluar->kel_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data Kotak Keluar'><i class='fas fa-trash'></i></a>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kotakkeluar->count_all($tgl1,$tgl2,$kotno),
            "recordsFiltered" => $this->kotakkeluar->count_filtered($tgl1,$tgl2,$kotno),
            "data" => $data,
            "query" => $this->kotakkeluar->getlastquery($tgl1,$tgl2,$kotno),
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari()
    {
        $id = $this->input->post('kel_id');
        $data = $this->kotakkeluar->ubah_kotakkeluar($id);
        echo json_encode($data);
    }

    public function get_donatur($donatur)
    {
        $data = $this->kotakkeluar->get_donatur();
        if ($data) {
            $result = "<option Pilih {$donatur}";
            foreach ($data as $dt) {
                $result .= "<option value={$dt->id}>{$dt->nama}</option>";
            }
        }
        echo $result;
    }

    public function simpan()
    {
        $id = $this->input->post('kel_id');
        $data = $this->input->post();
        $tgl = explode("/", $data['kel_tgl']);
        $data['kel_tgl'] = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";
        $his_tgl = $data['kel_tgl'];
        $jumlah = $this->kotakkeluar->get_stok();
        if ($jumlah) $his_stok = $jumlah->his_stok - 1;
        $jenis = '2';
        $ket = $this->input->post('kel_ket');
        $kotnomor = $this->input->post('kel_kot_nomor');

        $ceknomor = $this->kotakkeluar->cek_nomor($data['kel_kot_nomor']);

        if ($ceknomor == 0) {
            $insert = $this->kotakkeluar->simpan("ktk_kotak_keluar", $data);

            $error = $this->db->error();
            if (!empty($error)) {
                $err = $error['message'];
            } else {
                $err = "";
            }
            if ($insert) {
                if ($jumlah == null) {
                    $data1 = array(
                        'his_id' => $id,
                        'his_ref_id' => $insert,
                        'his_tgl' => $his_tgl,
                        'his_jenis' => $jenis,
                        'his_stok' => 1,
                        'his_ket' => $ket
                    );
                } else {
                    $data1 = array(
                        'his_id' => $id,
                        'his_ref_id' => $insert,
                        'his_tgl' => $his_tgl,
                        'his_jenis' => $jenis,
                        'his_stok' => $his_stok,
                        'his_ket' => $ket
                    );
                }

                $data2 = array(
                    'kot_status' => 1,
                    'kot_don_id' => $data['kel_don_id'],
                );

                $this->kotakkeluar->update("ktk_kotak", array('kot_nomor' => $kotnomor), $data2);

                $this->kotakkeluar->simpan("ktk_history", $data1);
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
        } else {
            $resp['status'] = 0;
            $resp['desc'] = "Kaleng tidak ditemukan";
        }

        echo json_encode($resp);
    }

    public function hapus($id)
    {
        $cek = $this->kotakkeluar->ubah_kotakkeluar($id);
        $delete = $this->kotakkeluar->delete('ktk_kotak_keluar', 'kel_id', $id);

        if ($delete) {
            $this->kotakkeluar->deleteMultCon('ktk_history', array(['field' => 'his_jenis', 'value' => 2], ['field' => 'his_ref_id', 'value' => $id]));
            $this->kotakkeluar->update('ktk_kotak', array('kot_nomor' => $cek->kel_kot_nomor), array('kot_status' => 0, 'kot_don_id' => null));
            $resp['status'] = 1;
            $resp['desc'] = "berhasil menghapus data";
        } else {
            $resp['status'] = 0;
            $resp['desc'] = "Gagal Menghapus! Kaleng sudah digunakan";
        }
        echo json_encode($resp);
    }
}
