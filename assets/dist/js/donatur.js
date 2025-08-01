var save_method; //for save method string
var table;

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
			"url": "ajax_list_donatur/",
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

function ubah_donatur(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "cari",
		data: "don_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);
			obj.map((dt) => {
				if (dt[0] == 'jadwal') {
					$('#dynamic_field').html(dt[1]);
				} else {
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