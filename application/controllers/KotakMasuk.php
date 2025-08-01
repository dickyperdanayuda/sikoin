<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KotakMasuk extends CI_Controller
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
        $this->load->model('Model_KotakMasuk', 'kotakmasuk');
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
            'subjudul' => "Kotak Masuk",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'kotak' => $this->kotakmasuk->get_kotakmasuk(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('kotak_masuk', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_kotak()
    {
        $list = $this->kotakmasuk->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kotak) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $this->kotakmasuk->tanggal($kotak->msk_tgl);
            $row[] = $kotak->msk_nomor_awal;
            $row[] = $kotak->msk_nomor_akhir;
            $row[] = $kotak->msk_jumlah;
            $row[] = $kotak->msk_ket;
            $row[] = "<a href='#' onClick='hapus_kotak(" . $kotak->msk_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data Kotak Masuk'><i class='fas fa-trash'></i></a>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kotakmasuk->count_all(),
            "recordsFiltered" => $this->kotakmasuk->count_filtered(),
            "data" => $data,
            "query" => $this->kotakmasuk->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari()
    {
        $id = $this->input->post('msk_id');
        $data = $this->kotakmasuk->ubah_kotakmasuk($id);
        echo json_encode($data);
    }

    public function simpan()
    {
        $noawal = $this->input->post('msk_nomor_awal');
        $noakhir = $this->input->post('msk_nomor_akhir');
        $range = range($noawal, $noakhir);
        $rentang = count($range);

        $id = $this->input->post('msk_id');
        $data = $this->input->post();
        $tgl = explode("/", $data['msk_tgl']);
        $data['msk_tgl'] = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";
        $data['msk_jumlah'] = $rentang;
        $his_tgl = $data['msk_tgl'];
        $jumlah = $this->kotakmasuk->get_stok();
        if ($noakhir < $noawal) {
            $resp['status'] = 0;
            $resp['desc'] = "Nomor akhir harus lebih besar dari nomor awal";
        } else {
            if ($jumlah) $his_stok = $rentang + $jumlah->his_stok;
            $jenis = '1';
            $ket = $this->input->post('msk_ket');

            $ceknomor = $this->kotakmasuk->cek_nomor($data['msk_nomor_awal'], $data['msk_nomor_akhir']);

            if (($id == 0) && ($ceknomor == 0)) {
                $insert = $this->kotakmasuk->simpan("ktk_kotak_masuk", $data);

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
                            'his_stok' => $rentang,
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

                    foreach ($range as $nomor) {
                        $data2[] = [
                            'kot_id' => $id,
                            'kot_ref_id' => $insert,
                            'kot_nomor' => $nomor,
                            'kot_status' => 0,
                        ];
                    }

                    for ($a = 0; $a < $rentang; $a++) {
                        $this->kotakmasuk->simpan("ktk_kotak", $data2[$a]);
                    }
                    $this->kotakmasuk->simpan("ktk_history", $data1);
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
                $resp['desc'] = "Gagal Menyimpan! Nomor sudah ada";
            }
        }
        echo json_encode($resp);
    }

    public function hapus($id)
    {
        $cek = $this->kotakmasuk->ubah_kotakmasuk($id);

        for ($b = $cek->msk_nomor_awal; $b <= $cek->msk_nomor_akhir; $b++) {
            $cek2 = $this->kotakmasuk->cek_kot_status($b);
            $xhapus = 0;
            if ((int)$cek2->kot_status > 0) {
                $xhapus = 1;
                break;
            }
        }
        if ($xhapus == 0) {
            $this->kotakmasuk->delete('ktk_kotak_masuk', 'msk_id', $id);
            $this->kotakmasuk->delete('ktk_kotak', 'kot_ref_id', $id);
            $this->kotakmasuk->deleteMultCon('ktk_history', array(['field' => 'his_jenis', 'value' => 1], ['field' => 'his_ref_id', 'value' => $id]));
            $resp['status'] = 1;
            $resp['desc'] = "berhasil menghapus data";
        } else {
            $resp['status'] = 0;
            $resp['desc'] = "Gagal Menghapus! Kaleng sudah digunakan";
        }
        echo json_encode($resp);
    }
}
