<?php
class Model_Kwitansi extends CI_Model
{

    var $table = 'ktk_kwitansi';
    var $column_order = array('kw_id', 'kw_pkw_id', 'kw_nomor', 'kw_pemegang', 'kw_status', 'kw_ket', 'kw_don_id', 'kw_tgl', 'kw_penerima'); //set column field database for datatable orderable
    var $column_search = array('kw_pkw_id', 'kw_nomor', 'kw_pemegang', 'kw_don_id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('kw_nomor' => 'asc'); // default order  	private $db_sts;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }

    public function get_kwitansi()
    {
        $this->db->from("ktk_kwitansi");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_nokwitansi($id)
    {
        $this->db->select("kw_nomor");
        $this->db->from("ktk_kwitansi");
        $this->db->where("kw_pemegang", $id);
        $this->db->where("kw_status", 0);
        $query = $this->db->get();

        return $query->result();
    }

    public function cari_kwitansi($id)
    {
        $this->db->from("ktk_kwitansi");
        $this->db->where("kw_id", $id);
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

    public function update($table, $where, $data)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function simpan($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function delete($table, $field, $id)
    {
        $this->db->where($field, $id);
        $this->db->delete($table);

        return $this->db->affected_rows();
    }
}
