var save_method; //for save method string
var table;

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
			"url": "ajax_list_kotak/",
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