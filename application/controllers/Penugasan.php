<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penugasan extends CI_Controller
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
        $this->load->model('Model_Penugasan', 'penugasan');
        $this->load->model('Model_Donatur', 'donatur');
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

    //penugasan	
    public function tampil()
    {
        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Penugasan",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'donatur' => $this->donatur->get_donatur(),
            'karyawan' => $this->karyawan->get_karyawan(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('penugasan', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_penugasan()
    {
        $list = $this->penugasan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $penugasan) {
            $kdon = $this->penugasan->get_kontak($penugasan->don_id);
            if ($kdon) {
                foreach ($kdon as $dkm) {
                    $nowa = preg_replace('/\D/', '', $dkm->kd_wa);
                    if (substr($nowa, 0, 1) == "0") {
                        $nowa = "62" . substr($dkm->kd_wa, 1);
                    }
                }
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $this->penugasan->tanggal($penugasan->tgs_tanggal);
            $row[] = $penugasan->kry_nama;
            $row[] = $penugasan->don_nama;
            if ($penugasan->tgs_status == 1) {
                $row[] = "Ditugaskan";
            } else if ($penugasan->tgs_status == 2) {
                $row[] = "Sudah Dijemput";
            } else if ($penugasan->tgs_status == 3) {
                $row[] = "Sudah Dihitung";
            } else if ($penugasan->tgs_status == 4) {
                $row[] = "Sudah Divalidasi";
            }
            $row[] = "<a href='#' onClick='hapus_penugasan(" . $penugasan->tgs_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data penugasan'><i class='fas fa-trash'></i></a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->penugasan->count_all(),
            "recordsFiltered" => $this->penugasan->count_filtered(),
            "data" => $data,
            "query" => $this->penugasan->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_donatur($jadwal)
    {
        $list = $this->donatur->get_datatables($jadwal);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $donatur) {
            $status = $this->penugasan->get_status($donatur->don_id);
            $kdon = $this->donatur->get_kontak($donatur->don_id);
            $nowa = "";
            if ($kdon) {
                foreach ($kdon as $dkm) {
                    $nowa = preg_replace('/\D/', '', $dkm->kd_wa);
                    if (substr($nowa, 0, 1) == "0") {
                        $nowa = "62" . substr($dkm->kd_wa, 1);
                    }
                }
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $donatur->don_nama;
            $row[] = $donatur->don_alamat;
            $row[] = $nowa;
            $row[] = $status ? $this->donatur->tanggal($status->tgs_tanggal) : "-";
            if ($status) {
                if ($status->tgs_status == 1) {
                    $tombol = "<a href='#' onClick='hapus_donatur(" . $donatur->don_id . ",this)' id='pilih{$donatur->don_id}' class='btn btn-danger btn-sm mr-3' title='Hapus donatur dari tugas'><i class='fas fa-trash'></i> Hapus</a>";
                }
                else 
                {
                    $tombol = "<a href='#' class='btn btn-info btn-sm mr-3' title='Sudah Dijemput'><i class='fas fa-check-circle'></i> Sudah Dijemput</a>";
                }
            }else {
                $tombol = "<a href='#' onClick='tambah_donatur(" . $donatur->don_id . ",this)' id='pilih{$donatur->don_id}' class='btn btn-success btn-sm mr-3' title='Tambahkan donatur ke tugas'><i class='fas fa-check-circle'></i> Pilih</a>";
            }
            $row[] = $tombol;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->donatur->count_all(),
            "recordsFiltered" => $this->donatur->count_filtered($jadwal),
            "data" => $data,
            "query" => $this->donatur->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari()
    {
        $id = $this->input->post('tgs_id');
        $data = $this->penugasan->cari_penugasan($id);
        echo json_encode($data);
    }

    public function simpan()
    {
        $id = $this->input->post('tgs_id');
        $data = $this->input->post();
        $tgl = explode("/", $data['tgs_tanggal']);
        $data['tgs_tanggal'] = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";
        $data['tgs_status'] = 1;
        // $pilihdon = [
        //     'tgs_id' => $id,
        //     'tgs_tanggal' => $data['tgs_tanggal'],
        //     'tgs_kry_id' => $data['tgs_kry_id'],
        //     'tgs_don_id' => $data['tgs_don_id'],
        //     'tgs_status' => 1,
        // ];
        if ($id == 0) {
            $insert = $this->penugasan->simpan("ktk_penugasan", $data);
        } else {
            $insert = $this->penugasan->update("ktk_penugasan", array('tgs_id' => $id), $data);
        }
        $error = $this->db->error();
        if ($insert) {
            // $data1 = [
            //     'jpt_tgs_id' => $insert,
            //     'jpt_tgs_tgl' => $data['tgs_tanggal'],
            //     'jpt_kry_id' => $data['tgs_kry_id'],
            //     'jpt_don_id' => $data['tgs_don_id'],
            // ];
            // $this->penugasan->simpan('ktk_penjemputan', $data1);
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menyimpan data";
        } else {
            if ($id == 0) {
                $resp['status'] = 0;
                $resp['desc'] = "Ada kesalahan dalam penyimpanan!";
                $resp['error'] = $error;
            } else {
                $resp['status'] = 1;
                $resp['desc'] = "Berhasil menyimpan data";
            }
        }
        echo json_encode($resp);
    }
    // public function simpan()
    // {
    //     $id = $this->input->post('tgs_id');
    //     $data = $this->input->post();
    //     $tgl = explode("/", $data['tgs_tanggal']);
    //     $data['tgs_tanggal'] = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";
    //     if ($data['don_mode'] == 1) {
    //         $pilihdon = [
    //             'tgs_id' => $id,
    //             'tgs_tanggal' => $data['tgs_tanggal'],
    //             'tgs_kry_id' => $data['tgs_kry_id'],
    //             'tgs_don_id' => $data['tgs_don_id'],
    //             'tgs_status' => 1,
    //         ];
    //         if ($id == 0) {
    //             $insert = $this->penugasan->simpan("ktk_penugasan", $pilihdon);
    //         } else {
    //             $insert = $this->penugasan->update("ktk_penugasan", array('tgs_id' => $id), $data);
    //         }
    //         $error = $this->db->error();
    //         if ($insert) {
    //             $resp['status'] = 1;
    //             $resp['desc'] = "Berhasil menyimpan data";
    //         } else {
    //             if ($id == 0) {
    //                 $resp['status'] = 0;
    //                 $resp['desc'] = "Ada kesalahan dalam penyimpanan!";
    //                 $resp['error'] = $error;
    //             } else {
    //                 $resp['status'] = 1;
    //                 $resp['desc'] = "Berhasil menyimpan data";
    //             }
    //         }
    //     } else {
    //         $cari_don = $this->penugasan->cari_don($id, $data['tgs_don_id']);
    //         $delete = $this->penugasan->delete('ktk_penugasan', 'tgs_id', $data['tgs_don_id']);
    //         if ($delete) {
    //             $resp['status'] = 1;
    //             $resp['desc'] = "Berhasil menghapus data";
    //         }
    //     }
    //     echo json_encode($resp);
    // }

    public function hapus($id)
    {
        $delete = $this->penugasan->delete('ktk_penugasan', 'tgs_id', $id);
        
        $resp['status'] = 0;
        $resp['desc'] = "Ada kesalahan saat menghapus tugas";
        if ($delete) {
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        } 
        echo json_encode($resp);
    }

    public function hapus_don($id)
    {
        $delete = $this->penugasan->delete('ktk_penugasan', 'tgs_don_id', $id);
        $resp['status'] = 0;
        $resp['desc'] = "Ada kesalahan saat menghapus tugas";
        if ($delete) {
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }
}
