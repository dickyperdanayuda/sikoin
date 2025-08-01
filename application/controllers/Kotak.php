<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kotak extends CI_Controller
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

    //Pembelian	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Kotak",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'kotak' => $this->kotak->get_kotak(),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('kotak', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_kotak()
    {
        $list = $this->kotak->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kotak) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kotak->kot_nomor;
            $row[] = $kotak->kot_status == 0 ? "Gudang" : "Disebar";
            $row[] = "<a href='#' onClick='hapus_kotak(" . $kotak->kot_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data Kotak'><i class='fas fa-trash'></i></a>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kotak->count_all(),
            "recordsFiltered" => $this->kotak->count_filtered(),
            "data" => $data,
            "query" => $this->kotak->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari()
    {
        $id = $this->input->post('kot_id');
        $data = $this->kotak->ubah_kotak($id);
        echo json_encode($data);
    }

    public function simpan()
    {
        $id = $this->input->post('kot_id');
        $data = $this->input->post();

        if ($id == 0) {
            $insert = $this->kotak->simpan("ktk_kotak", $data);
        } else {
            $insert = $this->kotak->update("ktk_kotak", array('kot_id' => $id), $data);
        }
        $error = $this->db->error();
        if (!empty($error)) {
            $err = $error['message'];
        } else {
            $err = "";
        }
        if ($insert) {
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
        $delete = $this->kotak->delete('ktk_kotak', 'kot_id', $id);
        if ($delete) {
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }
}
