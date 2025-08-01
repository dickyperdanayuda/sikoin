var save_method; //for save method string
var table;

function drawTable() {
    $('#tabel-penjemputan').DataTable({
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
            "url": "ajax_list_penjemputan/",
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

function tambah(id, don_nama, don_kry) {
    $("#jpt_tgs_id").val(id);
    $("#nama_don").html(don_nama);
    $("#nama_kry").html(don_kry);
    $("#div_kwitansi").hide();
    $("#div_jumlah").hide();
    $("#frm_penjemputan").trigger("reset");
    $('#modal_penjemputan').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}

function tampilPecahan(sh) {
    if (sh == 1) {
        $('#btnPecahan').attr('onclick', 'tampilPecahan()');
        $('#frm_pecahan').hide();
        $('#iconPecahan').addClass('fa-square');
        $('#iconPecahan').removeClass('fa-check-square');
    } else {
        $('#btnPecahan').attr('onclick', 'tampilPecahan(1)');
        $('#frm_pecahan').show();
        $('#iconPecahan').addClass('fa-check-square');
        $('#iconPecahan').removeClass('fa-square');
    }
}

$(".inputPecahan").keyup(function (e) {
    jml = $("#jmlPecahan").val();
    total = 0;
    for (i = 1; i <= jml; i++) {
        var nilai = $("#nilai_pecahan" + i).attr("nilai");
        var jmlnilai = $("#nilai_pecahan" + i).val();
        if (jmlnilai) {
            total += parseInt(nilai) * parseInt(jmlnilai);
        }
    }
    $("#jpt_jml_pecahan").val(total);
    if (total > 0) {
        $("#div_kwitansi").show();
        $("#jpt_kwitansi").prop("required", true);
        $("#div_jumlah").show();
    } else {
        $("#jpt_kwitansi").prop("required", false);
    }
});

$(".inputPecahan").change(function (e) {
    jml = $("#jmlPecahan").val();
    total = 0;
    for (i = 1; i <= jml; i++) {
        var nilai = $("#nilai_pecahan" + i).attr("nilai");
        var jmlnilai = $("#nilai_pecahan" + i).val();
        if (jmlnilai) {
            total += parseInt(nilai) * parseInt(jmlnilai);
        }
    }
    $("#jpt_jml_pecahan").val(total);
    if (total > 0) {
        $("#div_kwitansi").show();
        $("#jpt_kwitansi").prop("required", true);
        $("#div_jumlah").show();
    } else {
        $("#jpt_kwitansi").prop("required", false);
    }
})

$("#frm_penjemputan").submit(function (e) {
    e.preventDefault();
    $("#jpt_simpan").html("Menyimpan...");
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
                $("#modal_penjemputan").modal("hide");
            }
            else {
                toastr.error(res.desc);
            }
            $("#jpt_simpan").html("Simpan");
            $(".btn").attr("disabled", false);
        },
        error: function (jqXHR, namaStatus, errorThrown) {
            $("#jpt_simpan").html("Simpan");
            $(".btn").attr("disabled", false);
            alert('Error get data from ajax');
        }
    });
});

function reset_form() {
    $("#jpt_id").val(0);
    $("#frm_penjemputan")[0].reset();
}

function ubah_penjemputan(id) {
    $.ajax({
        type: "POST",
        url: "cari",
        data: "jpt_id=" + id,
        dataType: "json",
        success: function (data) {
            $(".inputPecahan").val(0);
            $("#jpt_id").val(id);
            // $("#jpt_kwitansi").val(data.jpt_kwitansi);
            data.map((dt) => {
                if (dt) {
                    $(".pecahan_uang_" + dt.pcg_jenis + "_" + dt.pcg_nilai).val(dt.pcg_jml);
                    $("#jpt_jml_pecahan").val(dt.jpt_jml_pecahan);
                    $("#jpt_tgs_tgl").val(dt.jpt_tgs_tgl);
                    $("#jpt_tgs_id").val(dt.jpt_tgs_id);
                    $("#jpt_kry_id").val(dt.jpt_kry_id);
                    $("#jpt_don_id").val(dt.jpt_don_id);
                    $("#nama_don").html(dt.don_nama);
                    $("#nama_kry").html(dt.kry_nama);
                    $("#jpt_kw_nomor").val(dt.jpt_kw_nomor);
                }
            });
            $("#frm_pecahan").show();
            $("#jpt_hapus").fadeIn(50);
            $(".inputan").attr("disabled", false);
            $("#modal_penjemputan").modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
            return false;
        }
    });
}

function hapus_penjemputan(id) {
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

$("#jpt_sumber").select2();
$(document).ready(function () {
    drawTable();
});