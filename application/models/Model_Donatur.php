<?php
class Model_Donatur extends CI_Model
{

	var $table = 'ktk_donatur';
	var $column_order = array('don_id', 'don_nama', 'don_alamat', 'kot_nomor', 'don_maps', 'don_status'); //set column field database for datatable orderable
	var $column_search = array('don_nama', 'don_alamat','kd_wa','kot_nomor'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('don_nama' => 'asc'); // default order  	private $db_sts;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($kotno)
	{

		$this->db->from($this->table);
		$this->db->join("ktk_kotak","kot_don_id = don_id","left");
		$this->db->join("ktk_kontak_donatur","kd_don_id = don_id","left");
		if ($kotno != 'null') 
		{
			$this->db->where("kot_nomor", $kotno);
		}


		// if ($jadwal == 2) {
		// 	$this->db->join("ktk_jadwal", "jwl_don_id = don_id", "left");
		// 	$this->db->where("jwl_tanggal", date('Y-m-d'));
		// } else if ($jadwal == 1) {
		// 	$this->db->join("ktk_kotak", "kot_don_id = don_id", "left");
		// 	$this->db->where("kot_don_id !=''");
		// } else {
		// 	return $tampil;
		// }
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

	function get_datatables($kotno)
	{
		$this->_get_datatables_query($kotno);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($kotno)
	{
		$this->_get_datatables_query($kotno);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_donatur()
	{
		$this->db->from("ktk_donatur");
		$query = $this->db->get();

		return $query->result();
	}
	public function get_kotakkel()
	{
		$this->db->select("kot_nomor");
		$this->db->from("ktk_kotak");
		$this->db->where("kot_don_id", null);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_kotak()
	{
		$this->db->select("kot_nomor");
		$this->db->from("ktk_kotak");
		$this->db->where("kot_status", 1);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_statuskotakkel()
	{
		$this->db->select("kot_status");
		$this->db->from("ktk_kotak");
		$query = $this->db->get();

		return $query->row();
	}

	public function get_petugas()
	{
		$this->db->from("ktk_karyawan");
		$query = $this->db->get();

		return $query->result();
	}

	public function get_kontak($id)
	{
		$this->db->from("ktk_kontak_donatur");
		$this->db->where("kd_don_id", $id);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_kontak_don($id)
	{
		$this->db->from("ktk_kontak_donatur");
		$this->db->where("kd_id", $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function cari_foto($id)
	{	$this->db->from("ktk_foto");
		$this->db->where("ft_id", $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_galery($id)
	{	$this->db->from("ktk_foto");
		$this->db->where("ft_don_id", $id);
		$this->db->order_by("ft_id", "desc");
		$query = $this->db->get();
		
		return $query->result();
	}

	public function cari_jadwal($id)
	{
		$this->db->from("ktk_jadwal");
		$this->db->where("jwl_don_id", $id);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_donatur($id)
	{
		$this->db->from("ktk_donatur");
		$this->db->join("ktk_kotak_keluar", "kel_don_id = don_id","left");
		$this->db->join("ktk_karyawan", "kel_kry_id = kry_id","left");
		$this->db->join("ktk_kotak", "kot_don_id = don_id","left");
		
		$this->db->where("don_id", $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function ubah_jadwal($id)
	{
		$this->db->from("ktk_jadwal");
		$this->db->where("jwl_don_id", $id);
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
