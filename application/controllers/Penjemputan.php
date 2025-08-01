<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjemputan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($this->session->userdata['id_user'])) {
        redirect(base_url("login"));
        }
        // if ($this->session->userdata("level") <> 1) {
        // redirect(base_url("Dashboard"));
        // }

        $this->load->library('upload');
        $this->load->model('Model_Penjemputan', 'penjemputan');
        $this->load->model('Model_Donatur', 'donatur');
        $this->load->model('Model_Karyawan', 'karyawan');
        $this->load->model('Model_Penugasan', 'penugasan');
        $this->load->model('Model_Pecahan', 'pecahan');
        $this->load->model('Model_Kwitansi', 'kwitansi');
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

    //penjemputan	
    public function tampil()
    {
        $userr = $this->session->userdata('log_kry');
        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Penjemputan",
        ];
        $d = [
            'donatur' => $this->donatur->get_donatur(),
            'karyawan' => $this->karyawan->get_karyawan(),
            'pecahan' => $this->pecahan->get_pecahan(),
            'kwitansi' => $this->kwitansi->get_nokwitansi($userr),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('penjemputan', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_penjemputan()
    {
        $userr = $this->session->userdata('log_kry');
        $list = $this->penugasan->get_datatables();
        // $list = $this->penjemputan->get_datatables();
        $data = array();
        $nowa = "";
        $no = $_POST['start'];
        foreach ($list as $penugasan) {
            $kdon = $this->penjemputan->get_kontak($penugasan->tgs_don_id);
            $jemput = $this->penjemputan->cari_jemput($penugasan->tgs_id);
            if ($kdon) {
                foreach ($kdon as $dkm) {
                    $nowa = preg_replace('/\D/', '', $dkm->kd_wa);
                    if (substr($nowa, 0, 1) == "0") {
                        $nowa = "62" . substr($dkm->kd_wa, 1);
                    }
                }
            }
            // var_dump($nowa);
            // exit();
            $wa = "<a href='https://wa.me/{$nowa}' target='_blank' class='btn btn-success btn-sm mr-3' title='Click to chat'><i class='text-white fab fa-whatsapp'></i>";
            $no++;
            $row = array();
            $row[] = $no;
            if ($jemput == null) {
                $row[] = "";
                $ubah = "";
                $hapus = "";
            } else {
                $ubah = "<a href='#' onClick='ubah_penjemputan({$jemput->jpt_id})' class='btn btn-info btn-sm mr-3' title='Ubah data penjemputan'><i class='fas fa-edit'></i></a>";
                $hapus = "<a href='#' onClick='hapus_penjemputan({$jemput->jpt_id})' class='btn btn-danger btn-sm mr-3' title='Hapus data penjemputan'><i class='fas fa-trash'></i></a>";
                $row[] = $jemput->jpt_tgl_jemput;
            }
            // $row[] = $jpt->jpt_tgl_jemput;
            $row[] = $penugasan->kry_nama;
            $row[] = $penugasan->kot_nomor;
            $row[] = $nowa;
            $row[] = $penugasan->don_nama;
            if ($penugasan->tgs_kry_id == $userr) {
                if ($penugasan->tgs_status > 1) {
                    $row[] = "<span class='badge badge-pill badge-success' title='Komfirmasi sudah dijemput'> Sudah Dijemput</span>";
                } else {
                    $row[] = "<a href='#' onClick='tambah({$penugasan->tgs_id},\"{$penugasan->don_nama}\",\"{$penugasan->kry_nama}\")' class='btn btn-danger btn-sm mr-3' title='Komfirmasi sudah dijemput'> Konfirmasi Jemput</a>";
                }
            } else {
                if ($penugasan->tgs_status > 1) {
                    $row[] = "<span class='badge badge-pill badge-success' title='Komfirmasi sudah dijemput'> Sudah Dijemput</span>";
                } else {
                    $row[] = "<span class='badge badge-pill badge-danger' title='Komfirmasi sudah dijemput'> Belum Dijemput</span>";
                }
            }
            $row[] = "<input type='text' class='form-control' onKeypress='simpan_ket({$penugasan->tgs_id},this.value)' value='{$penugasan->tgs_keterangan}'>";
            $row[] = "{$wa}{$ubah}{$hapus}";
            // $row[] = "<a href='#' onClick='tambah({$jpt->tgs_id},{$jpt->tgs_tanggal},{$jpt->tgs_kry_id},{$jpt->tgs_don_id})' class='btn btn-danger btn-sm mr-3' title='Komfirmasi sudah dijemput'> Konfirmasi Jemput</a>";
            // $row[] = "<a href='#' onClick='konfir_jpt(" . $jpt->jpt_id . ")' class='btn btn-danger btn-sm mr-3' title='Komfirmasi sudah dijemput'> Konfirmasi Jemput</a>";
            // $row[] = "<a href='https://wa.me/{$nowa}' target='_blank' class='btn btn-success btn-sm mr-3' title='Click to chat'><i class='text-white fab fa-whatsapp'></i><a href='#' onClick='ubah_penjemputan(" . $jpt->jpt_id . ")' class='btn btn-info btn-sm mr-3' title='Ubah data penjemputan'><i class='fas fa-edit'></i></a><a href='#' onClick='hapus_penjemputan(" . $jpt->jpt_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data penjemputan'><i class='fas fa-trash'></i></a>";
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

    public function cari()
    {
        $id = $this->input->post('jpt_id');
        $data = $this->penjemputan->ubah_penjemputan($id);
        echo json_encode($data);
    }

    public function simpan_ket()
    {
        $data = $this->input->post();
        $res = $this->penjemputan->update("ktk_penugasan", array("tgs_id" => $data['id']), array("tgs_keterangan" => $data['val']));
        echo $res;
    }

    public function simpan()
    {
        $id = $this->input->post('jpt_id');
        $id_tgs = $this->input->post('jpt_tgs_id');
        $no_kwitansi = $this->input->post('jpt_kw_nomor');
        $pcu = $this->input->post('nilai_pecahan');
        $data_tgs = $this->penugasan->cari_penugasan($id_tgs);
        $datapecahan = $this->pecahan->get_pecahan();
        $data = [
            'jpt_tgs_id' => $data_tgs->tgs_id,
            'jpt_tgs_tgl' => $data_tgs->tgs_tanggal,
            'jpt_tgl_jemput' => date('Y-m-d H:i:s'),
            'jpt_kry_id' => $data_tgs->tgs_kry_id,
            'jpt_don_id' => $data_tgs->tgs_don_id,
            'jpt_user_jemput' => $this->session->userdata['id_user'],
            'jpt_kw_nomor' => $no_kwitansi,
            'jpt_status' => 2,
        ];

        $error = $this->db->error();
        if (!empty($error)) {
            $err = $error['message'];
        } else {
            $err = "";
        }
        if ($id == 0) {
            $insert = $this->penjemputan->simpan("ktk_penjemputan", $data);
        } else {
            $insert = $this->penjemputan->update("ktk_penjemputan", array('jpt_id' => $id), $data);
        }
        if ($insert) {
            $insertpcu = "";
            $idjemput = $insert;
            if ($id > 0) $idjemput = $id;
            $this->penjemputan->delete('ktk_pecahan_pengumpulan', 'pcg_jpt_id', $idjemput);
            foreach ($datapecahan as $dpc) {
                $data1 = [
                    'pcg_jpt_id' => $idjemput,
                    'pcg_jenis' => $dpc->pec_jenis,
                    'pcg_nilai' => $dpc->pec_nilai,
                    'pcg_jml' => $pcu[$dpc->pec_id],
                ];
                if ($pcu[$dpc->pec_id]) $insertpcu = $this->penjemputan->simpan("ktk_pecahan_pengumpulan", $data1);
            }

            if ($insertpcu) {
                $data2 = [
                    'jpt_user_hitung' => $this->session->userdata['id_user'],
                    'jpt_tgl_hitung' => date('Y-m-d H:i:s'),
                    'jpt_jml_pecahan' => $this->input->post('jpt_jml_pecahan')
                ];
                $this->penjemputan->update("ktk_penjemputan", array('jpt_id' => $idjemput), $data2);
            }

            $data3 = [
                'tgs_status' => 2,
            ];
            $this->penjemputan->update("ktk_penugasan", array('tgs_id' => $id_tgs), $data3);

            $data4 = [
                'kw_status' => 1,
                'kw_don_id' => $data_tgs->tgs_don_id,
                'kw_tgl' => date('Y-m-d'),
            ];
            $this->penjemputan->update("ktk_kwitansi", array('kw_nomor' => $no_kwitansi), $data4);

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
                $this->penjemputan->delete('ktk_pecahan_pengumpulan', 'pcg_jpt_id', $insert);
                foreach ($datapecahan as $dpc) {
                    $data1 = [
                        'pcg_jpt_id' => $id,
                        'pcg_jenis' => $dpc->pec_jenis,
                        'pcg_nilai' => $dpc->pec_nilai,
                        'pcg_jml' => $pcu[$dpc->pec_id],
                    ];
                    if ($pcu[$dpc->pec_id]) $this->penjemputan->simpan("ktk_pecahan_pengumpulan", $data1);
                }
            }
        }
        echo json_encode($resp);
    }

    public function hapus($id)
    {
        $cek = $this->penjemputan->cari_penjemputan($id);
        $delete = $this->penjemputan->delete('ktk_penjemputan', 'jpt_id', $id);
        if ($delete) {
            $this->penjemputan->delete('ktk_pecahan_pengumpulan', 'pcg_jpt_id', $id);
            $this->penjemputan->update('ktk_penugasan', array('tgs_id' => $cek->jpt_tgs_id), array('tgs_status' => 1));
            // $this->penjemputan->update('ktk_kwitansi', array('kw_nomor' => $cek->jpt_kwitansi), array('kw_status' => 0, 'kw_don_id' => null, 'kw_tgl' => null));
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }
}
