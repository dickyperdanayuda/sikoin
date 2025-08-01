<div class="inner">
	<div class="row">
		<div class="col-md-3 col-xs-12">
			<div class="form-group">
				<input type="text" name="periode" id="periode" class="form-control range">
			</div>
		</div>
		<!-- <div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:void()"  class="btn btn-success btn-block" onClick="tampilkan()"><i class="fa fa-filter"></i> &nbsp;&nbsp;&nbsp; Tampilkan</a>
			</div>
		</div> -->
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
									<?php foreach ($kotaks as $kkel) {
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
					Data Kotak Keluar
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-kotak" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal Penyebaran</th>
								<th>Nama Donatur</th>
								<th>Nama Karyawan</th>
								<th>Nomor Kotak</th>
								<th>Alamat</th>
								<th>Keterangan</th>
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
<div class="modal fade" id="modal_kotak" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Kotak Keluar</h3>
			</div>
			<form role="form  col-lg-6" name="Kotak" id="frm_kotak">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="kel_id" name="kel_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Donatur</label>
								<select class="form-control select2" style="width:100%;" name="kel_don_id" id="kel_don_id">
									<option value="">== Pilih ==</option>
									<?php foreach ($donatur as $don) {
									?>
										<option value=<?= $don->don_id ?>><?= $don->don_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Karyawan</label>
								<select class="form-control select2" style="width:100%;" name="kel_kry_id" id="kel_kry_id">
									<?php foreach ($karyawan as $kry) {
									?>
										<option value=<?= $kry->kry_id ?>><?= $kry->kry_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Penyebaran</label>
								<input type="text" class="form-control tgl" name="kel_tgl" id="kel_tgl" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nomor Kotak</label>
								<select class="form-control" name="kel_kot_nomor" id="kel_kot_nomor" required>
									<?php foreach ($kotak as $kot) {
									?>
										<option value=<?= $kot->kot_nomor ?>><?= $kot->kot_nomor ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!-- <div class="col-lg-6">
							<div class="form-group">
								<label>Alamat</label>
								<input type="text" class="form-control ket" name="kel_alamat" id="kel_alamat" placeholder="Alamat">
							</div>
						</div> -->
						<div class="col-lg-6">
							<div class="form-group">
								<label>Keterangan</label>
								<input type="text" class="form-control ket" name="kel_ket" id="kel_ket" placeholder="Keterangan">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="kel_simpan" class="btn btn-success">Simpan</a>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
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
<!-- Custom Java Script -->
<script src="<?= base_url("assets/"); ?>dist/js/kotak.js"></script>
<script>
var save_method; //for save method string
var table;

var tgl1 = null;
var tgl2 = null;
var kotno = null;

function drawTable() {
	$('#tabel-kotak').DataTable({
		"destroy": true,
		dom: 'Bfrtip',
		lengthMenu: [
			[10, 25, 50, -1],
			['10 rows', '25 rows', '50 rows', 'Show all']
		],
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
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
			"url": "ajax_list_kotak/" + tgl1 + "/" + tgl2+ "/" + kotno,
			"type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [-1], //last column
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
	$("#kot_id").val(0);
	$("#frm_kotak").trigger("reset");
	$('#modal_kotak').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_kotak").submit(function (e) {
	// var dataString = $("#frm_karyawan").serialize();
	e.preventDefault();
	$("#kot_simpan").html("Menyimpan...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "POST",
		url: "simpan",
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function (d) {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				$("#modal_kotak").modal("hide");
				reset_form();
				drawTable();
			}
			else {
				toastr.error(res.desc);
			}
			$("#kot_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#kot_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

function reset_form() {
	$("#kot_id").val(0);
	$("#frm_kotak")[0].reset();
}

function hapus_kotak(id) {
	event.preventDefault();
	$("#id").val(id);
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_kotak(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "cari",
		data: "kot_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);

			$(".inputan").attr("disabled", false);
			$("#modal_kotak").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

$("#yaKonfirm").click(function () {
	var id = $("#id").val();

	$("#isiKonfirm").html("Sedang menghapus data...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "GET",
		url: "hapus/" + id,
		success: function (d) {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				$("#frmKonfirm").modal("hide");
				drawTable();
			}
			else {
				toastr.error(res.desc);
			}
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
});

function tampilkan() {
		event.preventDefault();
		var periode = $("#periode").val().split(" - ");
		var tgls1 = periode[0].split("/");
		tgl1 = tgls1[2] + "-" + tgls1[1] + "-" + tgls1[0];
		var tgls2 = periode[1].split("/");
		tgl2 = tgls2[2] + "-" + tgls2[1] + "-" + tgls2[0];
		drawTable();

	}
function cari_kot() {
	
	kotno = $("#kotakx").val();
	console.log(kotno);
	drawTable(kotno);
	
}

$(document).ready(function () {
	drawTable();
	$(".select2").select2();
	$(".ckotak").select2();

	$('.range').daterangepicker({
			locale: {
				format: 'DD/MM/YYYY'
			},
			showDropdowns: true,
			"autoApply": true,
			opens: 'left'
		}).on('apply.daterangepicker', function(ev, picker) {
			setTimeout(function() {

				var periode = $("#periode").val().split(" - ");
				var tgls1 = periode[0].split("/");
				tgl1 = tgls1[2] + "-" + tgls1[1] + "-" + tgls1[0];
				var tgls2 = periode[1].split("/");
				tgl2 = tgls2[2] + "-" + tgls2[1] + "-" + tgls2[0];
				drawTable();
			}, 100);
		});
});
</script>