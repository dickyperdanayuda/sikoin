var save_method; //for save method string
var table;
var tgl1 = null;
var tgl2 = null;

function drawTable() {
    $('#tabel-laporan').DataTable({
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
            "url": "ajax_list_laporan/" + tgl1 + "/" + tgl2,
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

function refresh() {
    tgl1 = null;
    tgl2 = null;
    drawTable();
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
            drawTable();
        }, 100);
    });
    drawTable();
});

$(document).ready(function () {
    drawTable();
});