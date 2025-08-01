<div class="inner">
	<div class="row">
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:tambah()" class="btn btn-success btn-block"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
			</div>
		</div>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:drawTable()" class="btn btn-success btn-block"><i class="fa fa-refresh"></i> &nbsp;&nbsp;&nbsp; Refresh</a>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-2 col-xs-12">
		<div class="form-group">
				
					<select type="text" name="kotakx" id="kotakx"  class="form-control ckotak" placeholder="Cari Kotak"  style="width:100%;">
									<option value="" > Cari Nomor Kotak</option>
									<?php foreach ($kotak as $kkel) {
									?>
										<option value=<?= $kkel->kot_nomor ?>><?= $kkel->kot_nomor ?></option>
									<?php } ?>
				</select>
								
		</div>
		</div>
		<div class="col-md-2 col-xs-12">
			<a href="javascript:cari_kot()" class="btn btn-success btn-block"><i class="fa fa-search"></i> &nbsp;&nbsp;&nbsp; Cari</a>
		</div>
		
	</div>
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					Data Donatur
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-donatur" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Nomor Kotak</th>
								<th>Maps</th>
								<th>Status</th>
								<th>Kontak</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3" align="center">Tidak ada data</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_donatur" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Donatur</h3>
			</div>
			<form role="form  col-lg-6" name="Donatur" id="frm_donatur">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="don_id" name="don_id" value="0">
						<input type="hidden" id="kel_id" name="kel_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Donatur</label>
								<input type="text" class="form-control" name="don_nama" id="don_nama" placeholder="Nama" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="don_status" id="don_status">
									<option value="">== Pilih Status ==</option>
									<option value=0>Tidak Aktif</option>
									<option value=1>Aktif</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Alamat</label>
								<textarea class="form-control" name="don_alamat" id="don_alamat" placeholder="Alamat" required></textarea>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Kontak</label>
								<input type="text" class="form-control" name="don_kontak" id="don_kontak" placeholder="Kontak Person">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Maps</label>
								<input type="text" class="form-control" name="don_maps" id="don_maps" placeholder="Maps">
							</div>
						</div>
						
						<div class="col-lg-6 " >
							<div class="form-group">
								<label>Karyawan</label>
								<select class="form-control select2"  onkeypress="myKeyPress(e)" style="width:100%;" name="kel_kry_id" id="kel_kry_id">
									<?php foreach ($petugas as $kry) {
									?>
										<option value=<?= $kry->kry_id ?>><?= $kry->kry_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Penyebaran</label>
								<input type="text" class="form-control tgl " name="kel_tgl" id="kel_tgl" autocomplete="off" required>
							</div>
						</div>
						
						<div class="col-lg-6" >
							<div class="form-group" id="adad" style="	">
								<label>Nomor Kotak</label>
								<select class="form-control" name="kel_kot_nomor" id="kel_kot_nomor" required>
									<?php foreach ($kotakkel as $kot) { 
									?>
										<option value=<?= $kot->kot_nomor ?>><?= $kot->kot_nomor ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group" id="gaada" style="display: none;">
								<label>Nomor Kotak</label>
								<input type="text" class="form-control" disabled name="kel_kot_nomor" id="kel_kot_nomor2">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Foto</label>
								<input type="file" class="form-control" accept=".png,.jpg,.gif" name="file_foto" id="file_foto" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Preview</label>
								<div class="row" style="border:1px solid #2d2e2d;height:200px;">
									<!--<img src="" id="previewFoto" width="100%" height="200px;">-->
									<div class="col-12" id="previewFoto"></div>
								</div>
							</div>
						</div>
						 
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="don_simpan" class="btn btn-success">Simpan</a>
						<button type="button" class="btn btn-danger" onclick="reset_form()" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_kontak_don" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Kontak Donatur</h3>
			</div>
			<form role="form  col-lg-6" name="Donatur" id="frm_kontak_don">
				<div class="modal-body form" style="overflow-y:auto;">
					<div class="row">
						<input type="hidden" id="kd_id" name="kd_id" value=0>
						<input type="hidden" id="kd_don_id" name="kd_don_id" value=0>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Kontak</label>
								<input type="text" class="form-control" name="kd_nama" id="kd_nama" placeholder="Nama" value="" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="kd_jk" id="kd_jk">
									<option value=1>Laki-laki</option>
									<option value=2>Perempuan</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Telp</label>
								<input type="text" class="form-control" name="kd_telp" id="kd_telp" placeholder="Telp" value="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Whatsapp</label>
								<input type="text" class="form-control" name="kd_wa" id="kd_wa" placeholder="Whatsapp" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="kd_simpan" class="btn btn-primary">Simpan</a>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<!-- Modal Ok -->	
	<div class="modal fade" id="modal_galery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title" id="jdl_galery">Galeri Foto</h4>
		  </div>
		  <div class="modal-body">
			<form id="frm_galery" name="frm_galery">
				<div class="row">
					<div class="col-3">
						<input type="hidden" class="form-control" id="ft_don_id" name="ft_don_id">
						<input type="text" class="form-control" id="ft_nama" name="ft_nama" placeholder="Deskripsi Foto" required>
					</div>
					<div class="col-3">
						<input type="file" class="form-control" id="foto" name="foto" placeholder="Foto" required>
					</div>
					<div class="col-3">
						<button type="submit" class="btn btn-success" id="up_galery">Upload</button>
					</div>
				</div>
			</form>
			<div class="row" id="isi_galery"></div>
		  </div>
		  <div class="modal-footer">
			<a href="#" data-dismiss="modal" class="btn btn-success" onClick="empty_konten()" id="okOk">Tutup</a>
		  </div>
		</div>
	  </div>
	</div>
	
<div class="modal fade" id="modal_jadwal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i>Jadwal Penjemputan</h3>
			</div>
			<form role="form  col-lg-6" name="Jadwal" id="frm_jwl_jemput">
				<label style="padding-left: 17px; color: green;">Jadwal penjemputan kotak infaq selama 1 tahun</label>
				<div class="modal-body form" style="overflow-y:auto;">
					<div class="row">
						<div class="col-lg-12" id="jadwal_jpt">
							<div class="form-group">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- DataTables -->
<script src="<?= base_url("assets"); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.colVis.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/pdfmake.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/vfs_fonts.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/jszip.min.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url("assets"); ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Select 2 -->
<script src="<?= base_url("assets"); ?>/plugins/select2/js/select2.full.js"></script>


<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Custom Java Script -->
<script>
var save_method; //for save method string
var table;
var kotno = null;

var imgInp = document.getElementById("file_foto");
// var blah = document.getElementById("previewFoto");
let foto;
imgInp.onchange = evt => {
	const [file] = imgInp.files
	if (file) {
		foto = URL.createObjectURL(file)
	}
	$("#previewFoto").attr("style","background-image:url('"+foto+"');background-position:center;background-repeat:no-repeat;background-size:contain;height:190px;width:100%;");
}

function drawTable() {
	$('#tabel-donatur').DataTable({
		"destroy": true,
		dom: 'Bfrtip',
		lengthMenu: [
			[10, 25, 50, -1],
			['10 rows', '25 rows', '50 rows', 'Show all']
		],
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print', 'colvis', 'pageLength'
		],
		// "oLanguage": {
		// "sProcessing": '<center><img src="<?= base_url("assets/");?>assets/img/fb.gif" style="width:2%;"> Loading Data</center>',
		// },
		"responsive": true,
		"sort": true,
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "ajax_list_donatur/" + kotno,
			"type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [-1,-2], //last column
				"orderable": false, //set not orderable
			},
		],
		"initComplete": function (settings, json) {
			$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
			$(".btn").attr("disabled", false);
			$("#isidata").fadeIn();
		}
	});
}

function tambah() {
	$("#don_id").val(0);
	$("#frm_donatur").trigger("reset");
	$('#modal_donatur').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_donatur").submit(function (e) {
	// var dataString = $("#frm_mitra").serialize();
	e.preventDefault();
	$("#don_simpan").html("Menyimpan...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "POST",
		url: "simpan",
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function (d) {
			var res = JSON.parse(d);
			console.log(res);
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				drawTable();
				reset_form();
				$("#modal_donatur").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#don_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#don_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});
});

function reset_form() {
	$("#don_id").val(0);
	$("#frm_donatur")[0].reset();
	$("#dynamic_field").html("<tr><td><input type='text' name='jwl_tanggal[]' class='form-control tgl' value='' /></td><td><button type='button' name='add' id='add' class='btn btn-success' onclick='add_row(2)'> + </button></td></tr>");

}

function hapus_donatur(id) {
	event.preventDefault();
	$("#id").val(id);
	$("#mode").val("hapus");
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_donatur(id,st, kn) {
	event.preventDefault();
	if(st == 0){
		$("#adad").show();
		$("#gaada").hide();
	}else if(st ==1 && kn == 0){
		$("#gaada").hide();
		$("#adad").show();
	}else{
		$("#adad").hide();
		$("#gaada").show();
	}
	$.ajax({
		type: "POST",
		url: "cari",
		data: "don_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);
			// console.log(obj);
			obj.map((dt) => {

				if (dt[0] == 'jadwal') {
					$('#dynamic_field').html(dt[1]);
				} 
			else if(dt[0]=='kel_kry_id'){
				if(dt[1] != null){
					$("#kel_kry_id").val(dt[1]).change();
				$("#kel_kry_id").prop('disabled', true);
				} else{

				}
			}
			else if(dt[0]=='kel_tgl'){
				if (dt[1] != null) {
					var tgl = dt[1].split("-");
				$("#"+dt[0]).val(tgl[2]+"/"+tgl[1]+"/"+tgl[0]);
				}else{

				}
				// $("#kel_tgl").val(dt[1]).change();
				// $("#kel_tgl").prop('disabled', true);
			}
			else if(dt[0]=='kel_kot_nomor'){
				// console.log(dt[1]);
				if (dt[1] != null) {
				$("#gaada").show();
				$("#adad").hide();
				$("#kel_kot_nomor2").val(dt[1]).change();
				}else{
				$("#adad").show();
				$("#gaada").hide();
				
				// $("#kel_kot_nomor2").hide();
				// $("#kel_kot_nomor").show();
				}
			}
				else {
					$("#" + dt[0]).val(dt[1]);
				}

				
			});

			$(".inputan").attr("disabled", false);
			$("#modal_donatur").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});

	// $.ajax({
	// 	type: "POST",
	// 	url: "cari_jwl",
	// 	data: "don_id=" + id,
	// 	dataType: "json",
	// 	success: function (data) {
	// 		var obj = Object.entries(data);
	// 		obj.map((dt) => {
	// 			if (dt[0] == "jwl_tanggal") {
	// 				var tgl = dt[1].split("-");
	// 				$("#" + dt[0]).val(tgl[2] + "/" + tgl[1] + "/" + tgl[0]);
	// 			}
	// 			else {
	// 				$("#" + dt[0]).val(dt[1]);
	// 			}
	// 		});

	// 		$(".inputan").attr("disabled", false);
	// 		$("#modal_donatur").modal({
	// 			show: true,
	// 			keyboard: false,
	// 			backdrop: 'static'
	// 		});
	// 		return false;
	// 	}
	// });
}

$("#frm_galery").submit(function(e){
	// var dataString = $("#frm_galery").serialize();
	var id = $("#ft_don_id").val();
	e.preventDefault();
	$("#up_galery").html("Mengupload...");
	$(".btn").attr("disabled", true);
	$("#loadPic1").show();
	$.ajax({
		type: "POST",
		url: "upload",  
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(d) 
		{
			var res = JSON.parse(d);
			var msg = "";
			if (res.isi == 1)
			{
				$("#frm_galery").trigger("reset");
				$.get("show_galery/"+id,{},function(data) {
					$("#isi_galery").html(data);
					return false;
				});
			}
			else
			{
				$("#loadPic1").hide();
				toastr.error(res.desc);
			}
			$("#up_galery").html("Upload");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, judulIsi, errorThrown)
		{
			$("#up_galery").html("Upload");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});
	
});

$("#frm_kontak_don").submit(function (e) {
	e.preventDefault();
	$("#kd_simpan").html("Menyimpan...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "POST",
		url: "simpankontak",
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function (d) {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				drawTable();
				reset_form();
				$("#modal_kontak_don").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#kd_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#kd_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

function tambah_kontak_don(id) {
	event.preventDefault();
	$("#frm_kontak_don").trigger("reset");
	$("#kd_don_id").val(id);
	$("#modal_kontak_don").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function hapus_kontak_don(id) {
	event.preventDefault();
	$("#id").val(id);
	$("#mode").val("hapuskontak");
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_kontak_don(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "carikontak",
		data: "kd_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);
			obj.map((dt) => {
				$("#" + dt[0]).val(dt[1]);
			});

			$(".inputan").attr("disabled", false);
			$("#modal_kontak_don").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function galery(id)
{
	event.preventDefault();
	$("#ft_don_id").val(id);
	$.get("show_galery/"+id,{},function(data) {
		$("#isi_galery").html(data);
		$("#modal_galery").modal("show");
	});
}


function jadwal_donatur(id) {
	event.preventDefault();
	$.get("carijadwal/" + id, {}, function (data) {
		$("#jadwal_jpt").html(data);
		$("#modal_jadwal").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	});
}
function add_row(i) {
	$('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added">' +
		'<td><input type="text" name="jwl_tanggal[]" id="jwl_tanggal" class="form-control tgl" /></td>' +
		'<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"> - </button></td></tr>');

}

$(document).ready(function () {
	$(document).on('click', '.btn_remove', function () {
		var button_id = $(this).attr("id");
		$('#row' + button_id + '').remove();
	});
	$(document).on('focus', '.tgl', function () {
		$(this).daterangepicker({
			locale: {
				format: 'DD/MM/YYYY'
			},
			showDropdowns: true,
			singleDatePicker: true,
			"autoApply": true,
			opens: 'left'
		});
	});
	drawTable();
});

$("#yaKonfirm").click(function () {
	var id = $("#id").val();
	var mode = $("#mode").val();
	$("#isiKonfirm").html("Sedang menghapus data...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "GET",
		url: mode + "/" + id,
		success: function (d) {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				$("#frmKonfirm").modal("hide");
				drawTable();
			}
			else {
				toastr.error(res.desc + "[" + res.err + "]");
			}
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
});

function cari_kot() {
	
	kotno = $("#kotakx").val();
	drawTable(kotno);
	
}

$(document).ready(function () {
	
	$(".select2").select2();
	$(".ckotak").select2();
});
</script>