var save_method; //for save method string
var table;
var filter = 1;

function filter_jadwal(mode) {
    if (mode == 2) {
        $('#filter_jwl').attr('onclick', 'filter_jadwal(1)');
        $('#filter_jwl').addClass('btn-success');
        $('#filter_jwl').removeClass('btn-danger');
        $('#cek_jwl').addClass('fa-check-square');
        $('#cek_jwl').removeClass('fa-square');
    } else {
        $('#filter_jwl').attr('onclick', 'filter_jadwal(2)');
        $('#filter_jwl').addClass('btn-danger');
        $('#filter_jwl').removeClass('btn-success');
        $('#cek_jwl').addClass('fa-square');
        $('#cek_jwl').removeClass('fa-check-square');
    }
    filter = mode;
    drawTableDon();
}

function drawTable() {
    $('#tabel-penugasan').DataTable({
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
            "url": "ajax_list_penugasan/",
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

function drawTableDon() {
    $('#tabel-donatur').DataTable({
        "destroy": true,
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength'
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
            "url": "ajax_list_donatur/" + filter,
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
            $("#isidatadon").fadeIn();
        }
    });
}

function tambah_donatur(id) {
    event.preventDefault();
    var tgs_tanggal = $('#tgs_tanggal').val();
    var tgs_kry = $('#tgs_kry_id').val();
    $(".btn").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "simpan",
        data: 'tgs_don_id=' + id + '&tgs_tanggal=' + tgs_tanggal + '&tgs_kry_id=' + tgs_kry,
        dataType: 'json',
        success: function (res) {
            if (res.status == 1) {
                $('#pilih' + id).addClass('btn-danger');
                $('#pilih' + id).removeClass('btn-success');
                $('#pilih' + id).html("<i class='fas fa-trash'></i> Hapus");
            }
            else {
                toastr.error(res.desc);
            }
            $(".btn").attr("disabled", false);
        },
        error: function (jqXHR, namaStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

function hapus_donatur(id) {
    event.preventDefault();
    $("#id").val(id);
    $(".btn").attr("disabled", true);
    $.ajax({
        type: "GET",
        url: "hapus_don/" + id,
        success: function (d) {
            var res = JSON.parse(d);
            if (res.status == 1) {
                toastr.success(res.desc);
                $('#pilih' + id).addClass('btn-success');
                $('#pilih' + id).removeClass('btn-danger');
                $('#pilih' + id).html("<i class='fas fa-check-circle'></i> Pilih");
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
}

function reset_form() {
    $("#tgs_id").val(0);
    $("#frm_penugasan")[0].reset();
}

function hapus_penugasan(id) {
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

function ubah_penugasan(id) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "cari",
        data: "tgs_id=" + id,
        dataType: "json",
        success: function (data) {
            var obj = Object.entries(data);
            obj.map((dt) => {
                if (dt[0] == "tgs_tanggal") {
                    var tgl = dt[1].split("-");
                    $("#" + dt[0]).val(tgl[2] + "/" + tgl[1] + "/" + tgl[0]);
                }
                else {
                    $("#" + dt[0]).val(dt[1]);
                }
            });

            $(".inputan").attr("disabled", false);
            $("#modal_penugasan").modal({
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