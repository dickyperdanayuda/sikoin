<?php
class Model_Laporan extends CI_Model
{

    var $table = 'ktk_penjemputan';
    var $column_order = array('jpt_id', 'jpt_tgs_tgl', 'jpt_kry_id', 'jpt_don_id', 'jpt_status'); //set column field database for datatable orderable
    var $column_search = array('jpt_tgs_tgl', "kry_nama", "don_nama"); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('jpt_tgs_tgl' => 'asc'); // default order  	private $db_sts;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($tgl1, $tgl2)
    {
        $this->db->from($this->table);
        $this->db->join("ktk_karyawan", "kry_id = jpt_kry_id", "left");
        $this->db->join("ktk_donatur", "don_id = jpt_don_id", "left");
        $this->db->join("ktk_kontak_donatur", "kd_don_id = jpt_don_id", "left");
        $this->db->join("ktk_penugasan", "tgs_id = jpt_tgs_id", "left");
        $this->db->join("ktk_kotak", "kot_don_id = jpt_don_id", "left");
        if ($tgl1 != 'null' and $tgl2 != 'null') {
            $this->db->where("jpt_tgl_jemput >= '{$tgl1} 00:00:00'");
            $this->db->where("jpt_tgl_jemput <= '{$tgl2} 23:59:59'");
        }
        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            foreach ($this->order as $key => $order) {
                $this->db->order_by($key, $order);
            }
        }
    }

    function get_datatables($tgl1, $tgl2)
    {
        $this->_get_datatables_query($tgl1, $tgl2);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($tgl1, $tgl2)
    {
        $this->_get_datatables_query($tgl1, $tgl2);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);

        return $this->db->count_all_results();
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
