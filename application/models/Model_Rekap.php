<?php
class Model_Rekap extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function get_rekap($tgl1, $tgl2)
    {
        $this->db->from("ktk_penjemputan");
        if ($tgl1 != 'null' and $tgl2 != 'null') {
            $this->db->where("jpt_tgl_jemput >= '{$tgl1} 00:00:00'");
            $this->db->where("jpt_tgl_jemput <= '{$tgl2} 23:59:59'");
        } else {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
            $this->db->where("jpt_tgl_jemput >= '{$tgl1} 00:00:00'");
            $this->db->where("jpt_tgl_jemput <= '{$tgl2} 23:59:59'");
        }
        $query = $this->db->get();

        return $query->result();
    }
    public function get_dijemput()
    {
        $this->db->select('jpt_id as jml');
        $this->db->from("ktk_penjemputan");
        $query = $this->db->get();

        return $query->num_rows();
    }
    public function get_dihitung()
    {
        $this->db->select('jpt_tgl_hitung as jml');
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgl_hitung !=''");
        $query = $this->db->get();

        return $query->num_rows();
    }
    public function get_blm_dihitung()
    {
        $this->db->select('jpt_tgl_hitung as jml');
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgl_hitung", null);
        $query = $this->db->get();

        return $query->num_rows();
    }
    public function get_uang_dihitung()
    {
        $this->db->select('sum(jpt_jml_pecahan) as jml');
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgl_hitung !=''");
        $query = $this->db->get();

        return $query->row();
    }
    public function get_divalidasi()
    {
        $this->db->select('jpt_tgl_validasi as jml');
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgl_validasi !=''");
        $query = $this->db->get();

        return $query->num_rows();
    }
    public function get_blm_divalidasi()
    {
        $this->db->select('jpt_tgl_validasi as jml');
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgl_hitung !=''");
        $this->db->where("jpt_tgl_validasi", null);
        $query = $this->db->get();

        return $query->num_rows();
    }
    public function get_uang_divalidasi()
    {
        $this->db->select('sum(jpt_jml_pecahan) as jml');
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgl_validasi !=''");
        $query = $this->db->get();

        return $query->row();
    }
    public function get_uang_blm_divalidasi()
    {
        $this->db->select('sum(jpt_jml_pecahan) as jml');
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgl_validasi", null);
        $query = $this->db->get();

        return $query->row();
    }

    public function tanggal($a)
    {
        $arrBulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $tgls = explode("-", $a);
        $tgl = $tgls[2];
        $bln = $arrBulan[(int) $tgls[1]];
        $thn = $tgls[0];
        return "$tgl $bln $thn";
    }

    // uang idr
    public function uang($nilai, $koma)
    {
        $uangnya = number_format($nilai, $koma);
        if ($koma > 0) {
            $pisah = explode(".", $uangnya);
            $depan = str_replace(",", ".", $pisah[0]);
            $belakang = str_replace(".", ",", $pisah[1]);
            $uang = "$depan,$belakang";
        } else {
            $uang = str_replace(",", ".", $uangnya);
        }
        return $uang;
    }

    public function getlastquery()
    {
        $query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

        return $query;
    }
}
