<?php
class Model_History extends CI_Model
{

	var $table = 'ktk_history';
	var $column_order = array('his_id', 'his_tgl', 'his_jenis', 'jml', 'his_stok', 'his_ket'); //set column field database for datatable orderable
	var $column_search = array('his_jenis', 'his_ket'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('his_id' => 'desc'); // default order  	private $db_sts;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($tgl1, $tgl2)
	{
		$this->db->select("ktk_history.*, if(his_jenis = 1,(select msk_jumlah from ktk_kotak_masuk where msk_id = his_ref_id),(select count(kel_tgl) from ktk_kotak_keluar where kel_tgl = his_tgl)) as jml");
		$this->db->from($this->table);
		if ($tgl1 != 'null' and $tgl2 != 'null') {
			$this->db->where("his_tgl >= '{$tgl1}'");
			$this->db->where("his_tgl <= '{$tgl2}'");
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

	public function get_history()
	{
		$this->db->from("ktk_history");
		$query = $this->db->get();

		return $query->result();
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

	public function get_enum($table, $field)
	{
		$q = "show columns from $table like '$field'";
		$row = $this->db->query("show columns from $table like '$field'")->row()->Type;
		$enum_array = explode("(", str_replace(")", "", str_replace("'", "", $row)));
		$enum_field = explode(",", $enum_array[1]);

		foreach ($enum_field as $key => $value) {
			$enums[$value] = $value;
		}
		return $enums;
	}
}
