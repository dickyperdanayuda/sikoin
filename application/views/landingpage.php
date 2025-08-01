<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>10K Per Bulan - Donasi Rumah Tahfizh</title>
  <link rel="icon" href="<?= base_url("assets/");?>dist/img/logo.png" type="image/png">
  <base href="/">
  <!-- Bootstrap core CSS --
  <link href="<?=base_url("assets");?>/gh/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?=base_url("assets");?>/gh/css/bootstrap.css" rel="stylesheet">
  <link href="<?=base_url("assets");?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
  
  <!-- Custom fonts for this template -->
  <link href="<?=base_url("assets");?>/gh/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="<?=base_url("assets");?>/gh/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  
  <!-- Custom styles for this template -->
  <link href="<?=base_url("assets");?>/gh/css/landing-page.css" rel="stylesheet">

<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=2799929186999959&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>

<body>

  <!-- Navigation --
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Start Bootstrap</a>
      <a class="btn btn-primary" href="#">Sign In</a>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="container text-white text-center">
	<div class="masthead row">
			<div class="col" style="width:95%;">
			  <div class="row mb-0 pb-0 pr-0">
				<div class="col-lg-6 p-0 pl-5 animate__animated animate__fadeInLeft" id="foto-artist" style="height:550px;">
					<div class="mb0" style="background-image:url('<?=base_url("assets");?>/gh/img/artist-1.png');background-size:contain;background-repeat:no-repeat;height:550px;"></div>
				</div>
				<div class="col-lg-1">&nbsp;</div>
				<div class="col-lg-5 text-right mr-0 pt-4 animate__animated animate__fadeInRight" id="bg-tulisan">
					<div class="p-3 bg-text ml-3">
						<h1 class="pr-3 font-aller" style="text-transform:capitalize;font-size:50px;" id="isi-tulisan">Mau mendapatkan pahala kebaikan semudah membaca tulisan ini ?</h1>
					</div>
				</div>
			  </div>
			</div>
	</div>
  </header>
  
  <!-- Page 2 Deskripsi -->
  <section class="container text-center mt-4 animate__animated animate__fadeInUp">
    <div class="deskripsi p-3 row">
		<div class="col">
			<h2 style="text-transform:uppercase;" class="font-montserrat main-text text-center mt-2" id="judul-ajakan">Form Donatur [ Rp. 10.000 / Bulan ]</h2>
			<p class="text-justify content-text">Donasi Tetap Rp. 10.000/bulan | Dengan minimal Rp. 10.000/bulan sudah menjadi bagian donatur DRT, donasi dapat ditransfer ke Rekening DRT (No. Rekening : 0795480194 an. Yayasan Generasi Umat Terbaik - BNI Syariah).</p>
			<p class="text-justify content-text">Semua dana yang dihimpun oleh Donasi Rumah Tahfizh diperuntukan untuk program Para Penghafal Al Qur'an, Rumah Tahfizh dan Sekolah Tahfizh.</p>
			<p class="text-justify info-text text-danger">*Nominal yang ditransfer sudah termasuk biaya operasonal</p>
		</div>
    </div>
  </section>
  
  <!-- Page 3 Persetujuan -->
  <section class="container mt-4 animate__animated animate__fadeInUp mb-3" id="form_konfirmasi">
    <div class="standar p-3 row">
		<div class="col">
			<p class="text-justify content-text">Dengan mengisi form ini, maka Bapak/Ibu bersedia menjadi DONATUR TETAP Donasi Rumah Tahfizh, seberar minimal Rp. 10.000 (dengan cara transfer sesuai ketentuan diatas) dan siap untuk berkomunikasi aktif dengan admin Donasi Rumah Tahfizh, serta tidak keberatan untuk diingatkan setiap bulan.</p>
			<input type="checkbox" onChange="tampilForm(this.id)" id="chk_setuju" class="mr-3" style="width:20px;height:20px;"><label style="position:relative;bottom:5px;">Saya Setuju</label>
		</div>
    </div>
  </section>
  
  <!-- Page 4 Oke -->
  <section class="container mt-4 animate__animated animate__fadeInUp mb-3" id="form_berhasil" style="display:none;">
    <div class="standar p-3 row">
		<div class="col">
			<h2 style="text-transform:uppercase;" class="font-montserrat main-text text-center mt-2">Pendaftaran Berhasil</h2>
			<p class="text-justify content-text">Alhamdulillah, Terima kasih telah mengikuti program "Rp 10.000 per Bulan" untuk para penghafal Qur'an. Semoga Allah memberikan balasan pahala melimpah yang terus mengalir kepada <b id="sapa"></b> dan keluarga.</p>
		</div>
    </div>
  </section>
  
  <!-- Page 4 Form -->
  <section class="container mt-4 animate__animated animate__fadeInUp mb-3" id="form_transfer" style="display:none;">
	<form role="form" name="frm_transfer" id="frm_transfer">
		<div class="standar p-3 row">
			<div class="col">
				<div class="form">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Nama Lengkap<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="don_nama" id="don_nama" placeholder="Jawaban Anda" value=""required>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="standar p-3 mt-2 row">
			<div class="col">
				<div class="form">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Jenis Kelamin<span class="text-danger">*</span></label>
								<div><input type="radio" class="mr-3" name="don_jk" id="don_jk_lk" value="1" style="width:20px;height:20px;" required> <label style="position:relative;bottom:5px;">Laki-Laki</label></div>
								<div><input type="radio" class="mr-3" name="don_jk" id="don_jk_pr" value="2" style="width:20px;height:20px;" required> <label style="position:relative;bottom:5px;">Perempuan</label></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="standar p-3 mt-2 row">
			<div class="col">
				<div class="form">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>No Whatsapp<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="don_wa" id="don_wa" placeholder="Jawaban Anda" value="" required>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="standar p-3 mt-2 row">
			<div class="col">
				<div class="form">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="don_email" id="don_email" placeholder="Jawaban Anda" value="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="standar p-3 mt-2 row">
			<div class="col">
				<div class="form">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Alamat</label>
								<textarea class="form-control" name="don_alamat" id="don_alamat" placeholder="Jawaban Anda" onFocus="autoSize(this)" onInput="autoSize(this)"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="standar p-3 mt-2 row">
			<div class="col">
				<div class="form">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input type="text" class="form-control tgl" name="don_tgl_lahir" id="don_tgl_lahir" placeholder="Jawaban Anda" value="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="standar p-3 mt-2 row">
			<div class="col">
				<div class="form">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Dari mana mendapatkan informasi tentang Donasi Rumah Tahfizh</label>
								<?php foreach($info as $inf) 
								{
									?>
									<div><input type="checkbox" name="info[]" value="<?=$inf;?>" style="width:20px;height:20px;" class="mr-3"> <label style="position:relative;bottom:5px;"><?=$inf;?></label></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="p-0 mt-3 row">
			<div class="col p-0">
				<button type="submit" id="simpan_transfer" class="btn btn-success btn-flat">Simpan</button>
			</div>
		</div>
	</form>
  </section>
  
	<!-- Modal Ok -->	
	<div class="modal fade" id="frmWakaf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form role="form  col-lg-6" name="Wakaf" id="frm_wakaf">
			<div class="modal-body form">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label>No Whatsapp (Digunakan untuk konfirmasi dan follow up)</label>
							<input type="text" class="form-control" name="wkf_wa" id="wkf_wa" placeholder="Nomor Whatsapp" value=""required>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" class="form-control" name="wkf_nama" id="wkf_nama" placeholder="Nama" value="" onKeyUp="isi_an(this.value)" required>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label>Berwakaf Atas Nama</label>
							<input type="text" class="form-control" name="wkf_atasnama" id="wkf_atasnama" placeholder="Atas Nama" value="">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label>Nominal Wakaf</label>
							<select class="form-control" name="wkf_jmlf" id="wkf_jmlf" onChange="pilih_nominal(this.value)">
							<?php 
								$base = 75000;
								$mult = 2;
								for ($i=1;$i<20;$i++) { 
								if ($i <= 5) 
								{
									$nom = $i * $mult * $base;
								}
								else 
								{
									$nom *= 2;
								}
								$jml = $nom / $base;
								if ($jml < 10000) 
								{							
							?>
								<option value=<?=$nom;?>>Rp. <?= number_format($nom,0,",",".");?> <?=" (".number_format($jml,0,",",".")." kubik tanah)";?></option>
								<?php 
								}
							}?>
								<option value=0>Jumlah Lainnya</option>
							</select>
							<input type="text" class="form-control" style="display:none;" placeholder="Nominal Wakaf" id="wkf_jmlb">
						</div>
					</div>
					<hr/>
					<div class="col-12">
						<div class="text-danger" style="font-size:12px;">*Nominal di atas sudah termasuk biaya operasional</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" id="wkf_simpan" class="btn btn-success">Wakafkan</a>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Lihat Dulu</button>
			</div>
			</form>
		</div>
	  </div>
	</div>
	
	<!-- Modal Ok -->	
	<div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-body">
			<div id="isiInfo" class="row text-center">
				<div class="col-3"><i class="fa fa-check-circle text-success text-center" style="font-size:60px;"></i></div>
				<div class="col-9 text-justify">Nomor Whatsapp ini Anda sudah didaftarkan, silakan daftarkan nomor lain untuk bergabung dalam program Rp. 10.000 per Bulan</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<a href="#" data-dismiss="modal" onClick="tutup_info()" class="btn btn-success btn-sm">Tutup</a>
		  </div>
		</div>
	  </div>
	</div>
  
  <!-- Bootstrap core JavaScript -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
  <script src="<?=base_url("assets");?>/gh/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <!-- Daterange Picker -->
  <script src="<?=base_url("assets");?>/plugins/daterangepicker/moment.min.js"></script>
  <script src="<?=base_url("assets");?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Toastr -->
<script src="<?= base_url("assets");?>/plugins/toastr/toastr.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
  <script>new WOW().init();</script>
  <script src="<?=base_url("assets");?>/gh/js/main.js"></script>

</body>

</html>