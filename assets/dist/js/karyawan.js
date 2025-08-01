var save_method; //for save method string
var table;

function drawTable() {
	$('#tabel-karyawan').DataTable({ 
		"destroy": true,
		dom: 'Bfrtip',
		lengthMenu: [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
		],
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print','pageLength'
		],
		// "oLanguage": {
			// "sProcessing": '<center><img src="<?= base_url("assets/");?>assets/img/fb.gif" style="width:2%;"> Loading Data</center>',
		// },
		"responsive": true,
		"sort":true,
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "ajax_list_karyawan/",
			"type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
		{ 
			"targets": [ -1 ], //last column
			"orderable": false, //set not orderable
		},
		],
		"initComplete": function(settings, json) {
			$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
			$(".btn").attr("disabled", false);
			$("#isidata").fadeIn();
		}
	});
}

function tambah(){
	$("#kry_id").val(0);
	$("#frm_karyawan").trigger("reset");
	$('#modal_karyawan').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#kry_nokitas").change(function(){
	var isi = $(this).val();
	if (isi == "Prodi")
	{
		$("#inputProdi").show();
		$("#inputFakultas").hide();
	}
	else
	{
		$("#inputProdi").hide();
		$("#inputFakultas").show();
	}
		// alert(isi);
});

$("#frm_karyawan").submit(function(e){
	// var dataString = $("#frm_karyawan").serialize();
	e.preventDefault();
	$("#kry_simpan").html("Menyimpan...");
	$(".btn").attr("disabled", true);
	$.ajax({
       type: "POST",
		url: "simpan",  
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(d) 
        {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1)
			{
				toastr.success(res.desc);
				drawTable();
				reset_form();
				$("#modal_karyawan").modal("hide");
			}
			else
			{
				toastr.error(res.desc);
			}
			$("#kry_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
        },
        error: function (jqXHR, namaStatus, errorThrown)
        {
			$("#kry_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
            alert('Error get data from ajax');
        }
    });
	
});

function reset_form()
{
	$("#kry_id").val(0);
	$("#frm_karyawan")[0].reset();
}

function hapus_karyawan(id)
{
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

function ubah_karyawan(id)
{
	event.preventDefault();
	$.ajax({
		type	: "POST",
		url		: "cari",
		data	: "kry_id="+id,
		dataType : "json",				  
		success	: function(data){
			var obj = Object.entries(data);
			obj.map((dt) => {
				if (dt[0] == "kry_tgl_lahir")
				{
					var tgl = dt[1].split("-");
					$("#"+dt[0]).val(tgl[2]+"/"+tgl[1]+"/"+tgl[0]);
				}
				else 
				{
					$("#"+dt[0]).val(dt[1]);
				}
			});
			
			$(".inputan").attr("disabled",false);
			$("#modal_karyawan").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function cek_karyawan(wa)
{
	event.preventDefault();
	$.ajax({
		type	: "POST",
		url		: "caribywa",
		data	: "kry_telp="+wa,
		dataType : "json",				  
		success	: function(data){
			if (data)
			{
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "kry_tgl_lahir")
					{
						var tgl = dt[1].split("-");
						$("#"+dt[0]).val(tgl[2]+"/"+tgl[1]+"/"+tgl[0]);
					}
					else 
					{
						$("#"+dt[0]).val(dt[1]);
					}
				});
			}
			else
			{
				$("#kry_id").val(0);
			}
			return false;
		}
	});
}

$("#yaKonfirm").click(function(){
	var id = $("#id").val();

	$("#isiKonfirm").html("Sedang menghapus data...");
	$(".btn").attr("disabled", true);
	$.ajax({
       type: "GET",
		url: "hapus/"+id,  
		success: function(d) 
        {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1)
			{
				toastr.success(res.desc);
				$("#frmKonfirm").modal("hide");
				drawTable();
			}
			else
			{
				toastr.error(res.desc + "["+res.err+"]");
			}
			$(".btn").attr("disabled", false);
        },
        error: function (jqXHR, namaStatus, errorThrown)
        {
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

$("#kry_sumber").select2();
$(document).ready(function() {
	drawTable();
});