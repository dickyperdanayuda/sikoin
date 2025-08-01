var save_method; //for save method string
var table;
var tgl1 = null;
var tgl2 = null;

function tampil_rekap() {
    $.ajax({
        type: "GET",
        url: "cari_rekap/" + tgl1 + "/" + tgl2,
        dataType: "json",
        success: function (data) {
            $("#jpt").html(data.totaljpt);
            $("#htg").html(data.totalhtg);
            $("#blm_htg").html(data.totalblmhtg);
            $("#uang_htg").html(data.totaljmluang);
            $("#valid").html(data.totalvalid);
            $("#blm_valid").html(data.totalblmvalid);
            $("#uang_valid").html(data.totaluangvalid);
            $("#uang_blm_valid").html(data.totaluangblmvalid);
            return false;
        }
    });
}

function refresh() {
    tgl1 = null;
    tgl2 = null;
    tampil_rekap();
}

$(document).ready(function () {

    $('.range').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        showDropdowns: true,
        "autoApply": true,
        opens: 'left'
    }).on('apply.daterangepicker', function (ev, picker) {
        setTimeout(function () {

            var periode = $("#filter_tanggal").val().split(" - ");
            var tgls1 = periode[0].split("/");
            tgl1 = tgls1[2] + "-" + tgls1[1] + "-" + tgls1[0];
            var tgls2 = periode[1].split("/");
            tgl2 = tgls2[2] + "-" + tgls2[1] + "-" + tgls2[0];
            tampil_rekap();
        }, 100);
    });
    // drawTable();
    tampil_rekap();
});