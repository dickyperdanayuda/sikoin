<?php
class Model_Penjemputan extends CI_Model
{

    var $table = 'ktk_penjemputan';
    var $column_order = array('jpt_id', 'jpt_tgs_tgl', 'jpt_kry_id', 'jpt_don_id', 'jpt_status'); //set column field database for datatable orderable
    var $column_search = array('jpt_tgs_tgl', 'kry_nama', 'don_nama', 'kot_nomor', 'kd_wa'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('jpt_tgs_tgl' => 'asc'); // default order  	private $db_sts;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $this->db->join("ktk_karyawan", "kry_id = jpt_kry_id", "left");
        $this->db->join("ktk_donatur", "don_id = jpt_don_id", "left");
        $this->db->join("ktk_kontak_donatur", "kd_don_id = jpt_don_id", "left");
        $this->db->join("ktk_penugasan", "tgs_id = jpt_tgs_id", "left");
        $this->db->join("ktk_kotak", "kot_don_id = don_id", "left");
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

    public function get_penjemputan()
    {
        $this->db->from("ktk_penjemputan");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_penjemputan2($id)
    {
        $this->db->from("ktk_penjemputan");
        $this->db->join("ktk_karyawan", "kry_id = jpt_kry_id", "left");
        $this->db->join("ktk_donatur", "don_id = jpt_don_id", "left");
        $this->db->join("ktk_kontak_donatur", "kd_don_id = jpt_don_id", "left");
        $this->db->join("ktk_penugasan", "tgs_id = jpt_tgs_id", "left");
        $this->db->join("ktk_kotak", "kot_don_id = jpt_don_id", "left");
        $this->db->join("ktk_pecahan_pengumpulan", "pcg_jpt_id = jpt_id", "left");
        $this->db->where("jpt_id", $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function cari_penjemputan($id)
    {
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_id", $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function ubah_penjemputan($id)
    {
        $this->db->from("ktk_penjemputan");
        $this->db->join("ktk_pecahan_pengumpulan", "pcg_jpt_id = jpt_id", "left");
        $this->db->join("ktk_karyawan", "kry_id = jpt_kry_id", "left");
        $this->db->join("ktk_donatur", "don_id = jpt_don_id", "left");
        $this->db->where("jpt_id", $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function cari_pecahan($id)
    {
        $this->db->from("ktk_penjemputan");
        $this->db->join("ktk_pecahan_pengumpulan", "pcg_jpt_id = jpt_id", "left");
        $this->db->where("jpt_id", $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function cari_pecahan2($id)
    {
        $this->db->from("ktk_pecahan_uang");
        $this->db->join("ktk_pecahan_pengumpulan", "pcg_nilai = pec_nilai and pcg_jenis = pec_jenis", "left");
        $this->db->join("ktk_penjemputan", "pcg_jpt_id = jpt_id", "left");
        $this->db->where("jpt_id", $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function cari_penyetor($id)
    {
        $this->db->from("ktk_spesimen");
        $this->db->join("ktk_penjemputan", "jpt_user_hitung = sps_kry_id", "left");
        $this->db->where("sps_kry_id", $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function cari_penerima($id)
    {
        $this->db->from("ktk_spesimen");
        $this->db->join("ktk_penjemputan", "jpt_user_jemput = sps_kry_id", "left");
        $this->db->join("ktk_login", "log_kry_id = sps_kry_id", "left");
        $this->db->where("sps_kry_id", $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function cari_jemput($id)
    {
        $this->db->select("jpt_tgl_jemput, jpt_id");
        $this->db->from("ktk_penjemputan");
        $this->db->where("jpt_tgs_id", $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_kontak($id)
    {
        $this->db->from("ktk_kontak_donatur");
        $this->db->where("kd_don_id", $id);
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

    public function terbilang($angka)
    {
        // pastikan kita hanya berususan dengan tipe data numeric
        $angka = (float)$angka;

        // array bilangan 
        // sepuluh dan sebelas merupakan special karena awalan 'se'
        $bilangan = array(
            '',
            'Satu',
            'Dua',
            'Tiga',
            'Empat',
            'Lima',
            'Enam',
            'Tujuh',
            'Delapan',
            'Sembilan',
            'Sepuluh',
            'Sebelas'
        );

        // pencocokan dimulai dari satuan angka terkecil
        if ($angka < 12) {
            // mapping angka ke index array $bilangan
            return $bilangan[$angka];
        } else if ($angka < 20) {
            // bilangan 'belasan'
            // misal 18 maka 18 - 10 = 8
            return $bilangan[$angka - 10] . ' Belas';
        } else if ($angka < 100) {
            // bilangan 'puluhan'
            // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'Dua'
            // untuk mendapatkan sisa bagi gunakan modulus
            // 27 mod 10 = 7 'Tujuh'
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) {
            // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
            // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
            // daripada menulis ulang rutin kode puluhan maka gunakan
            // saja fungsi rekursif dengan memanggil fungsi $this->terbilang(51)
            return sprintf('Seratus %s', $this->terbilang($angka - 100));
        } else if ($angka < 1000) {
            // bilangan 'ratusan'
            // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'Empat'
            // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif $this->terbilang(67))
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
        } else if ($angka < 2000) {
            // bilangan 'seribuan'
            // misal 1250 maka 1250 - 1000 = 250 (ratusan)
            // gunakan rekursif $this->terbilang(250)
            return trim(sprintf('Seribu %s', $this->terbilang($angka - 1000)));
        } else if ($angka < 1000000) {
            // bilangan 'ribuan' (sampai ratusan ribu
            $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
            $hasil_mod = $angka % 1000;
            return sprintf('%s Ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
        } else if ($angka < 1000000000) {
            // bilangan 'jutaan' (sampai ratusan juta)
            // 'satu puluh' => SALAH
            // 'satu ratus' => SALAH
            // 'satu juta' => BENAR 
            // @#$%^ WT*

            // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
            $hasil_bagi = (int)($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s Juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000) {
            // bilangan 'milyaran'
            $hasil_bagi = (int)($angka / 1000000000);
            // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
            // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s Milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000000) {
            // bilangan 'triliun'
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s Triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else {
            return 'Wow...';
        }
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
