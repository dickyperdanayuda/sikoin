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
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					Data Spesimen
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-spesimen" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Karyawan</th>
								<th>Nama Spesimen</th>
								<th>Foto TTD</th>
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
<div class="modal fade" id="modal_spesimen" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Spesimen</h3>
			</div>
			<form role="form  col-lg-6" name="Spesimen" id="frm_spesimen">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="sps_id" name="sps_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Karyawan</label>
								<select class="form-control" name="sps_kry_id" id="sps_kry_id" required>
									<option value="">== Pilih ==</option>
									<?php foreach ($karyawan as $kry) { ?>
										<option value="<?= $kry->kry_id ?>"><?= $kry->kry_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Spesimen</label>
								<input type="text" class="form-control" name="sps_nama" id="sps_id" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Foto TTD</label>
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
					<button type="submit" id="sps_simpan" class="btn btn-success">Simpan</a>
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
<script src="<?= base_url("assets"); ?>/plugins/select2/select2.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Custom Java Script -->
<script>
var save_method; //for save method string
var table;
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
	$('#tabel-spesimen').DataTable({
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
			"url": "ajax_list_spesimen/",
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
	$("#sps_id").val(0);
	$("#frm_spesimen").trigger("reset");
	$('#modal_spesimen').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_spesimen").submit(function (e) {
	// var dataString = $("#frm_karyawan").serialize();
	e.preventDefault();
	$("#sps_simpan").html("Menyimpan...");
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
				drawTable();
				reset_form();
				$("#modal_spesimen").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#sps_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#sps_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

function reset_form() {
	$("#sps_id").val(0);
	$("#frm_spesimen")[0].reset();
}

function hapus_spesimen(id) {
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

function ubah_spesimen(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "cari",
		data: "sps_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);
			obj.map((dt) => {
				if (dt) {
					$("#sps_kry_id").val(dt.sps_kry_id);
					$("#sps_kry_ttd").html(dt.sps_kry_ttd);
				}
			});

			$(".inputan").attr("disabled", false);
			$("#modal_spesimen").modal({
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
				toastr.error(res.desc + "[" + res.err + "]");
			}
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
});

$('.tgl').daterangepicker({
	locale: {
		format: 'DD/MM/YYYY'
	},
	showDropdowns: true,
	singleDatePicker: true,
	"autoApkry": true,
	opens: 'left'
});

$(document).ready(function () {
	drawTable();
});
</script>