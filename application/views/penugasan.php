<div class="inner">
    <div class="row">
        <div class="col-md-2 col-xs-12">
            <div class="form-group">
                <a href="javascript:drawTableDon()" data-target="#modal_penugasan" data-toggle="modal" class="btn btn-success btn-block" onClick="drawTableDon()"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
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
                    Data Penugasan
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tabel-penugasan" width="100%" style="font-size:120%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Karyawan</th>
                                <th>Nama Donatur</th>
                                <th>Status</th>
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

<div class="modal fade" id="modal_penugasan" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Pilih Donatur</h3>
            </div>
            <form role="form  col-lg-6" name="Penugasan" id="frm_penugasan">
                <div class="modal-body form">
                    <div class="row">
                        <input type="hidden" id="tgs_id" name="tgs_id" value="">
                        <input type="hidden" id="tgs_status" name="tgs_status" value=0>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tanggal Penugasan</label>
                                <input type="text" class="form-control tgl" name="tgs_tanggal" id="tgs_tanggal" placeholder="Tanggal Penugasan">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Karyawan</label>
                                <select class="form-control" name="tgs_kry_id" id="tgs_kry_id">
                                    <?php foreach ($karyawan as $kry) {
                                    ?>
                                        <option value=<?= $kry->kry_id ?>><?= $kry->kry_nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- <button type="button" onclick="filter_jadwal(2)" class="btn btn-danger" id="filter_jwl" style="margin: 10px; "><i class="fas fa-square" id="cek_jwl"></i> Tampilkan sesuai jadwal</button> -->
                    </div>
                    <div class="row" id="isidatadon">
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
                                                <th>Nama Donatur</th>
                                                <th>Alamat</th>
                                                <th>Kontak</th>
                                                <th>Penugasan Terakhir</th>
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
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="drawTable()" data-dismiss="modal">Tutup</button>
            </div>
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

function tambah_donatur(id,ele) {
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
                $(ele).removeClass('btn-success');
                $(ele).addClass('btn-danger');
                $(ele).attr('onClick','hapus_donatur('+id+',this)');
                $(ele).html("<i class='fas fa-trash'></i> Hapus");
                toastr.success(res.desc);
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

function hapus_donatur(id,ele) {
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
                $(ele).removeClass('btn-danger');
                $(ele).addClass('btn-success');
                $(ele).attr('onClick','tambah_donatur('+id+',this)');
                $(ele).html("<i class='fas fa-check-circle'></i> Pilih");
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
</script>