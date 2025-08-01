<?php
class Model_Dashboard extends CI_Model
{

	var $table = 'evt_penjualan_detail';
	var $column_order = array('pjd_jml', 'pjd_jml', 'pjd_jml', 'pjd_profit'); //set column field database for datatable orderable
	var $column_search = array('prd_nama'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pjd_profit' => 'desc'); // default order  	private $db_sts;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($tgl1, $tgl2)
	{
		$this->db->select('sum(pjd_jml) as pjd_jml, sum(((pjd_harga_jual-pjd_harga_modal)* pjd_jml) - pjd_diskon) as pjd_profit, prd_nama');
		$this->db->from($this->table);
		$this->db->join('evt_produk', 'prd_id = pjd_prd_id', 'left');
		$this->db->join('evt_penjualan', 'pjl_id = pjd_pjl_id', 'left');
		if (($tgl1 != 'null') && ($tgl2 != 'null')) {
			$this->db->where('pjl_tgl >= "' . $tgl1 . '"');
			$this->db->where('pjl_tgl <= "' . $tgl2 . '"');
		}
		$this->db->group_by('pjd_prd_id');

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
		$this->db->group_by('pjd_prd_id');

		return $this->db->count_all_results();
	}

	public function get_donatur()
	{
		$this->db->from("ktk_donatur");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_kotak()
	{
		$this->db->from("ktk_kotak");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_kotakkeluar()
	{
		$this->db->from("ktk_kotak_keluar");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_penugasan($id)
	{
		$this->db->from("ktk_penugasan");
		$this->db->where("tgs_kry_id", $id);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_kwitansi($id)
	{
		$this->db->from("ktk_kwitansi");
		$this->db->where("kw_pemegang", $id);
		$query = $this->db->get();

		return $query->num_rows();
	}

	// uang idr
	public function bulat($nilai, $koma)
	{
		$sat = "";
		$nb = $nilai;
		if ($nilai > 1000000000) {
			$sat = "M";
			$nb = $nilai / 1000000000;
		} else {
			if ($nilai > 1000000) {
				$sat = "JT";
				$nb = $nilai / 1000000;
			} else {
				if ($nilai > 1000) {
					$sat = "RB";
					$nb = $nilai / 1000;
				}
			}
		}
		$bulat = number_format($nb, $koma, ",", ".") . " " . $sat;
		return $bulat;
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
