<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pecahan extends CI_Controller
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
        $this->load->model('Model_Pecahan', 'pecahan');
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

    //Pecahan	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Pecahan",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        $d = [
            'pecahan' => $this->pecahan->get_pecahan(),
            'jns_pecahan' => $this->pecahan->get_enum('ktk_pecahan_uang', 'pec_jenis'),
        ];
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('pecahan', $d);
        $this->load->view('background_bawah');
    }

    public function ajax_list_pecahan()
    {
        $list = $this->pecahan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pecahan) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pecahan->pec_jenis;
            $row[] = $pecahan->pec_nilai;
            $row[] = "<a href='#' onClick='hapus_pecahan(" . $pecahan->pec_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data Pecahan'><i class='fas fa-trash'></i></a>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pecahan->count_all(),
            "recordsFiltered" => $this->pecahan->count_filtered(),
            "data" => $data,
            "query" => $this->pecahan->getlastquery(),
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari()
    {
        $id = $this->input->post('pec_id');
        $data = $this->pecahan->ubah_pecahan($id);
        echo json_encode($data);
    }

    public function simpan()
    {
        $id = $this->input->post('pec_id');
        $data = $this->input->post();

        if ($id == 0) {
            $insert = $this->pecahan->simpan("ktk_pecahan_uang", $data);
        } else {
            $insert = $this->pecahan->update("ktk_pecahan_uang", array('pec_id' => $id), $data);
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
        $delete = $this->pecahan->delete('ktk_pecahan_uang', 'pec_id', $id);
        if ($delete) {
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }
}
