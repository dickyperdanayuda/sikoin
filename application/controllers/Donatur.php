<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Donatur extends CI_Controller
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
        $this->load->model('Model_Donatur', 'donatur');
        $this->load->model('Model_KotakKeluar', 'kotakkeluar');
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

    //Donatur	
    public function tampil()
    {

        $this->session->set_userdata("judul", "Data Master");
        $ba = [
            'judul' => "Data Master",
            'subjudul' => "Donatur",
        ];
        // $info = ['WhatsApp','Instagram','Facebook','Stand','Teman','Spanduk','Brosur','Pengajian Ustadz','Youtube','Lainnya'];
        // $donatur = $this->donatur->cari_donatur();
        $petugas = $this->donatur->get_petugas();
        $kotakkel = $this->donatur->get_kotakkel();
        $kotak = $this->donatur->get_kotak();
        $statuskotakkel = $this->donatur->get_statuskotakkel();

        $d = [
            // 'donatur' => $donatur,
            'petugas' => $petugas,
            'kotakkel' => $kotakkel,
            'kotak' =>$kotak,
            'statuskotakkel' => $statuskotakkel,
            ];

        // print_r($kotakkel);
        // exit();
        $this->load->helper('url');
        $this->load->view('background_atas', $ba);
        $this->load->view('donatur', $d);
        $this->load->view('background_bawah');
    }
    public function ajax_list_donatur($kotno = null)
    {
        $list = $this->donatur->get_datatables($kotno);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $donatur) {
            $kontak = "";
            $ktk = $this->donatur->get_kontak($donatur->don_id);
            if ($ktk) {
                $kontak = "<ol>";
                foreach ($ktk as $dkm) {
                    $nowa = preg_replace('/\D/', '', $dkm->kd_wa);
                    if (substr($nowa, 0, 1) == "0") {
                        $nowa = "62" . substr($dkm->kd_wa, 1);
                    }
                    $telp = "";
                    if ($dkm->kd_telp) $telp = "<a href='tel:{$dkm->kd_telp}' class='pl-2'><i class='text-white fas fa-phone' style='color:#d5d5d5;'></i></a>";
                    $kontak .= "<li><span class='badge badge-pill badge-primary'>{$dkm->kd_nama} {$telp}<a href='https://wa.me/{$nowa}' target='_blank' class='pl-2'><i class='text-white fab fa-whatsapp' style='color:#d5d5d5;'></i></a><a href='#' onClick='ubah_kontak_don({$dkm->kd_id})' class='pl-2'><i class='text-white fas fa-edit' style='color:#d5d5d5;'></i></a><a href='#' onClick='hapus_kontak_don({$dkm->kd_id})' class='pl-2'><i class='text-white fas fa-trash' style='color:#d5d5d5;'></i></a></span></li>";
                }
                $kontak .= "</ol>";
            }
            $kontak .= "<a href='#' onClick='tambah_kontak_don({$donatur->don_id})' class='btn btn-xs btn-success'><i class='fa fa-plus'></i></a>";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $donatur->don_nama;
            $row[] = $donatur->don_alamat;
            $row[] = $donatur->kot_nomor;
            $row[] = $donatur->don_maps ? "<a href='{$donatur->don_maps}' class='btn btn-success btn-sm' target='_blank'><i class='fas fa-map-marker'></i></a>":"<span class='badge bg-secondary'>No Maps</span>" ;
            $row[] = $donatur->don_status == 1 ? "Aktif" : "Tidak Aktif";
            $row[] = $kontak;
            // $row[] = "<a href='#' onClick='jadwal_donatur(" . $donatur->don_id . ")' class='btn btn-info btn-sm mr-3' title='Jadwal Penjemputan'><b>Lihat Jadwal</b></a>";
            $row[] = "<a href='#' onClick='galery(".$donatur->don_id.")' class='btn btn-success btn-sm mr-3' title='Galery Foto'><i class='fas fa-image'></i></a><a href='#' onClick='ubah_donatur(" . $donatur->don_id . ",".$donatur->don_status.",".$donatur->kot_nomor.")' class='btn btn-info btn-sm mr-3' title='Ubah data donatur'><i class='fas fa-edit'></i></a><a href='#' onClick='hapus_donatur(" . $donatur->don_id . ")' class='btn btn-danger btn-sm mr-3' title='Hapus data donatur'><i class='fas fa-trash'></i></a>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->donatur->count_all($kotno),
            "recordsFiltered" => $this->donatur->count_filtered($kotno),
            "data" => $data,
            "query" => $this->donatur->getlastquery($kotno),
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari()
    {
        $id = $this->input->post('don_id');
        
        $data = $this->donatur->cari_donatur($id);

        $data1 = $this->donatur->cari_jadwal($id);

        $result = "";
        $max = count($data1);
        foreach ($data1 as $idx => $dt) {
            $tgl1 = explode("-", $dt->jwl_tanggal);
            $jadwal = "{$tgl1[2]}/{$tgl1[1]}/{$tgl1[0]}";
            $i = $idx + 1;
            if ($idx == 0) {
                $result .= "<tr>
                    <td><input type='text' name='jwl_tanggal[]' class='form-control tgl' value='{$jadwal}' /></td>
                    <td><button type='button' name='add' id='add' class='btn btn-success' onclick='add_row({$max})'> + </button></td>
                </tr>";
            } else {
                $result .= "<tr id='row{$i}' class='dynamic-added'>
                    <td><input type='text' name='jwl_tanggal[]' class='form-control tgl' value='{$jadwal}' /></td>
                    <td><button type='button' name='remove' id='{$i}' class='btn btn-danger btn_remove'> - </button></td>
                </tr>";
            }
        }
        $data->jadwal = $result;

        // print_r($data);
        // exit(); 
        echo json_encode($data);
    }

	public function show_galery($id)
	{
		$data = $this->donatur->get_galery($id);
		$d = [
		'id' => $id,
		'data' => $data
		];
		$this->load->view("isigalery",$d);
	}
	
    public function carikontak()
    {
        $id = $this->input->post('kd_id');
        $data = $this->donatur->cari_kontak_don($id);
        echo json_encode($data);
    }

    public function carijadwal($id)
    {
        $data = $this->donatur->cari_jadwal($id);
        $result = "<ol>";
        foreach ($data as $dt) {
            $result .= "<li style='font-size: 25px;'><span class='badge badge-pill badge-primary'>{$this->donatur->tanggal($dt->jwl_tanggal)}</span></li>";
        }
        $result .= "</ol>";
        echo $result;
    }

	public function upload()
	{
		$data = $this->input->post();
		$nama = $data['ft_don_id']."-".str_replace(' ','-',str_replace("  "," ",trim($data['ft_nama'])));
		if(!empty($_FILES['foto']['name'])){
			if (!is_dir('assets/files/donatur'))
			{
				mkdir('assets/files/donatur', 0777, TRUE);
				mkdir('assets/files/donatur/thumbs', 0777, TRUE);
			}
			$path = $_FILES['foto']['name'];
			$ext =  pathinfo($path, PATHINFO_EXTENSION);
			$config['upload_path'] = 'assets/files/donatur/'; //path folder
			$config['allowed_types'] = '*'; //type yang dapat diakses bisa anda sesuaikan
			$config['encrypt_name'] = FALSE; //Enkripsi nama yang terupload
			$config['overwrite'] = TRUE; //Gantikan file dengan nama yang sama
			$config['file_name'] = "{$nama}.".microtime(true).".".$ext; //ganti nama file
			$this->upload->initialize($config);
			if ($this->upload->do_upload('foto'))
			{
				$foto = $this->upload->data();
				//Compress Image
				$config['image_library']='gd2';
				$config['source_image']='assets/files/donatur/'.$foto['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '50%';
				$config['width']= 150;
				$config['height']= 150;
				$config['new_image']= 'assets/files/donatur/thumbs/'.$foto['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				
                $dfoto = [
                    "ft_don_id" => $data['ft_don_id'],
                    "ft_nama" => $data['ft_nama'],
                    "ft_link" => base_url("assets/files/donatur/{$foto['file_name']}"),
                    "ft_size" => $foto['file_size'],
                    "ft_type" => $foto['image_type'],
                ];
			}
			else
			{
				print_r($this->upload->display_errors());
			}
		}
		$insert = $this->donatur->simpan("ktk_foto", $dfoto);
		
		$error = $this->db->error();
		if (!empty($error))
		{
			$err = $error['message'];
		}
		else 
		{
			$err = "";
		}
		if ($insert)
		{
			$resp['isi'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		}
		else 
		{
			$resp['isi'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}
	
    public function simpan()
    {
        $id = $this->input->post('don_id');
        $alldata = $this->input->post();
        $kel_id = $this->input->post('kel_id');
        // var_dump($kel_id);
        // exit();
        $don_nama = $this->input->post('don_nama');
        $don_status = $this->input->post('don_status');
        $don_alamat = $this->input->post('don_alamat');
        $don_kontak = $this->input->post('don_kontak');
        $don_maps = $this->input->post('don_maps');
        $file_foto = $this->input->post('file_foto');

       

        $data = array(
            'don_nama' => $don_nama,
            'don_status' => $don_status,
            'don_alamat' => $don_alamat,
            'don_kontak' => $don_kontak,
            'don_maps' => $don_maps,
            'file_foto' => $file_foto,

        );
        // var_dump($data);
        // exit();
		// $jwl = null;
		// $idjwl = null;
        
		// if (isset($data['jwl_tanggal']))
		// {
		// 	$jwl = $data['jwl_tanggal'];
		// 	$idjwl = $data['jwl_id'];
		// }
        if ($data['don_maps'])
        {
            $maps = explode("http",$data['don_maps']);
            $data['don_maps'] = "http".$maps[1];
        }
        unset($data['file_foto']);
        unset($data['don_kontak']);
        if ($id == 0) {
            $insert = $this->donatur->simpan("ktk_donatur", $data);
        } else {
            $insert = $this->donatur->update("ktk_donatur", array('don_id' => $id), $data);
        }
        $error = $this->db->error();
        if (!empty($error)) {
            $err = $error['message'];
        } else {
            $err = "";
        }
        if ($insert) {

        // data kotak keluar
        $kel_don_id = $insert;
        
        $kel_kry_id = $this->input->post('kel_kry_id');

        $tgl = explode("/", $this->input->post('kel_tgl'));
        $tglkel = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";
        $his_tgl = $tglkel;
        $jumlah = $this->kotakkeluar->get_stok();
        if ($jumlah) $his_stok = $jumlah->his_stok - 1;
        $jenis = '2';
        $ket = $this->input->post('kel_ket');
        $kel_kot_nomor = $this->input->post('kel_kot_nomor'); 


        $ceknomor = $this->kotakkeluar->cek_nomor($this->input->post('kel_kot_nomor'));  
        // var_dump($ceknomor);
        // exit();
        $datakkel = array(
                'kel_don_id' => $kel_don_id,
                'kel_kry_id' => $kel_kry_id,
                'kel_tgl' => $tglkel,
                'kel_kot_nomor' => $kel_kot_nomor,
        );

        if ($ceknomor == 0) {
                
                $insert2 = $this->kotakkeluar->simpan("ktk_kotak_keluar", $datakkel);
            
            if ($insert2) {
                $his_id = $id;
                if ($jumlah == null) {
                    $data1 = array(
                        'his_id' => $id,
                        'his_ref_id' => $insert2,
                        'his_tgl' => $his_tgl,
                        'his_jenis' => $jenis,
                        'his_stok' => 1,
                    );
                } else {
                    $data1 = array(
                        'his_id' => $id,
                        'his_ref_id' => $insert2,
                        'his_tgl' => $his_tgl,
                        'his_jenis' => $jenis,
                        'his_stok' => $his_stok,
                    );
                }

                $data2 = array(
                    'kot_status' => 1,
                    'kot_don_id' => $kel_don_id,
                );

                $this->kotakkeluar->update("ktk_kotak", array('kot_nomor' => $kel_kot_nomor), $data2);

               if ($his_id == null) {
                    $this->kotakkeluar->simpan("ktk_history", $data1);
               }else{
                    $this->kotakkeluar->update("ktk_history",array('his_id' => $his_id), $data1);
               }
                
            } else {
               
            }
        } else {
        }

        // batas kotak keluar

            if (!$id or $id == 0)
            {
                $don_id = $insert;
                
                $dkontak = [
                    "kd_don_id" => $don_id,
                    "kd_jk" => 1,
                    "kd_nama" => $alldata['don_nama'],
                    "kd_telp" => $alldata['don_kontak'],
                    "kd_wa" => $alldata['don_kontak'],
                ];
                $this->donatur->simpan("ktk_kontak_donatur", $dkontak);

                $nama = str_replace(' ', '-', trim($data['don_nama']));
                if (!empty($_FILES['file_foto']['name'])) {
                    if (!is_dir('assets/files/donatur')) {
                        mkdir('assets/files/donatur', 0777, TRUE);
                        mkdir('assets/files/donatur/thumbs', 0777, TRUE);
                    }
                    $path = $_FILES['file_foto']['name'];
                    $ext =  pathinfo($path, PATHINFO_EXTENSION);
                    $config['upload_path'] = 'assets/files/donatur/'; //path folder
                    $config['allowed_types'] = '*'; //type yang dapat diakses bisa anda sesuaikan
                    $config['encrypt_name'] = FALSE; //Enkripsi nama yang terupload
                    $config['overwrite'] = TRUE; //Gantikan file dengan nama yang sama
                    $config['file_name'] = "{$nama}." . $ext; //ganti nama file

                    $this->upload->initialize($config);
                }

                if (!empty($_FILES['file_foto']['name'])) {

                    if ($this->upload->do_upload('file_foto')) {
                        $foto = $this->upload->data();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = 'assets/files/donatur/' . $foto['file_name'];
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE;
                        $config['quality'] = '50%';
                        $config['width'] = 150;
                        $config['height'] = 150;
                        $config['new_image'] = 'assets/files/donatur/thumbs/' . $foto['file_name'];
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $dfoto = [
                            "ft_don_id" => $don_id,
                            "ft_nama" => $foto['file_name'],
                            "ft_link" => base_url("assets/files/donatur/{$foto['file_name']}"),
                            "ft_size" => $foto['file_size'],
                            "ft_type" => $foto['image_type'],
                        ];
                        $this->donatur->simpan("ktk_foto",$dfoto);
                    }
                }

            }
            
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menyimpan data";
        } else {
                 $kel_don_id = $id;
        
                $kel_kry_id = $this->input->post('kel_kry_id');

                $tgl = explode("/", $this->input->post('kel_tgl'));
                $tglkel = "{$tgl[2]}-{$tgl[1]}-{$tgl[0]}";
                $his_tgl = $tglkel;
                $jumlah = $this->kotakkeluar->get_stok();
                if ($jumlah) $his_stok = $jumlah->his_stok - 1;
                $jenis = '2';
                $ket = $this->input->post('kel_ket');
                $kel_kot_nomor = $this->input->post('kel_kot_nomor'); 


                $ceknomor = $this->kotakkeluar->cek_nomor($this->input->post('kel_kot_nomor'));  
                // var_dump($ceknomor);
                // exit();
                $datakkel = array(
                        'kel_don_id' => $kel_don_id,
                        'kel_kry_id' => $kel_kry_id,
                        'kel_tgl' => $tglkel,
                        'kel_kot_nomor' => $kel_kot_nomor,
                );

                if ($ceknomor == 0) {
                        
                        $insert2 = $this->kotakkeluar->simpan("ktk_kotak_keluar", $datakkel);
                    
                    if ($insert2) {
                        $his_id = $id;
                        if ($jumlah == null) {
                            $data1 = array(
                                'his_id' => $id,
                                'his_ref_id' => $insert2,
                                'his_tgl' => $his_tgl,
                                'his_jenis' => $jenis,
                                'his_stok' => 1,
                            );
                        } else {
                            $data1 = array(
                                'his_id' => $id,
                                'his_ref_id' => $insert2,
                                'his_tgl' => $his_tgl,
                                'his_jenis' => $jenis,
                                'his_stok' => $his_stok,
                            );
                        }

                        $data2 = array(
                            'kot_status' => 1,
                            'kot_don_id' => $kel_don_id,
                        );

                        $this->kotakkeluar->update("ktk_kotak", array('kot_nomor' => $kel_kot_nomor), $data2);

                       if ($his_id == null) {
                            $this->kotakkeluar->simpan("ktk_history", $data1);
                       }else{
                            $this->kotakkeluar->update("ktk_history",array('his_id' => $his_id), $data1);
                       }
                        
                    } else {
                       
                    }
                } else {
                }
                $resp['status'] = 1;
                $resp['desc'] = "Berhasil menyimpan data";
            // batas
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

    public function simpankontak()
    {
        $id = $this->input->post('kd_id');
        $data = $this->input->post();

        if ($id == 0) {
            $insert = $this->donatur->simpan("ktk_kontak_donatur", $data);
        } else {
            $insert = $this->donatur->update("ktk_kontak_donatur", array('kd_id' => $id), $data);
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
        $delete = $this->donatur->delete('ktk_donatur', 'don_id', $id);
        if ($delete) {
            $delete = $this->donatur->delete('ktk_kontak_donatur', 'kd_don_id', $id);
            $delete = $this->donatur->delete('ktk_foto', 'ft_don_id', $id);
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }

    public function hapus_foto($id)
    {
        $data = $this->donatur->cari_foto($id);
        $delete = $this->donatur->delete('ktk_foto', 'ft_id', $id);
        if ($delete) {
            unlink($data->ft_link);
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }

    public function hapuskontak($id)
    {
        $delete = $this->donatur->delete('ktk_kontak_donatur', 'kd_id', $id);
        if ($delete) {
            $resp['status'] = 1;
            $resp['desc'] = "Berhasil menghapus data";
        }
        echo json_encode($resp);
    }
}
