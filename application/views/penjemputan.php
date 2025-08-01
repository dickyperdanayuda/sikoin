<div class="inner">
    <div class="row">
        <!-- <div class="col-md-2 col-xs-12">
            <div class="form-group">
                <a href="javascript:tambah()" class="btn btn-success btn-block"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
            </div>
        </div> -->
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
                    Data Penjemputan
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tabel-penjemputan" width="100%" style="font-size:120%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Jemput</th>
                                <th>Karyawan</th>
                                <th>Nomor Kotak</th>
                                <th>WA</th>
                                <th>Donatur</th>
                                <th>Status</th>
                                <th>Ket</th>
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
<div class="modal fade" id="modal_penjemputan" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Penjemputan</h3>
            </div>
            <form role="form  col-lg-6" name="Penjemputan" id="frm_penjemputan">
                <div class="modal-body form">
                    <div class="row">
                        <input type="hidden" id="jpt_tgs_id" name="jpt_tgs_id">
                        <input type="hidden" id="jpt_id" name="jpt_id" value="">
                        <input type="hidden" id="pcg_id" name="pcg_id" value="">
                        <input type="hidden" id="jpt_user_jemput" name="jpt_user_jemput" value="">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama Donatur :</label>
                                <label id="nama_don" style="font-weight:normal;"></label>
                            </div>
                            <div class="form-group">
                                <label>Petugas Jemput :</label>
                                <label id="nama_kry" style="font-weight:normal;"></label>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <a href="javascript:void()" id="btnPecahan" class="btn btn-primary" sh=0 onClick="tampilPecahan(this.id)"><i id="iconPecahan" class="fa fa-square"></i> Hitung Uang</a>
                        </div>
                    </div>
                    <div id="frm_pecahan" class="col-lg-12" style="display:none;margin-top:10px;border:1px solid #d3d3d3;padding:5px 5px 5px 5px;">
                        <div class="row">
                            <div class="col-lg-6" id="div_kwitansi">
                                <div class="form-group">
                                    <label>Nomor Kwitansi</label>
                                    <select id="jpt_kw_nomor" name="jpt_kw_nomor" class="form-control">
                                        <option value="">== Pilih ==</option>
                                        <?php foreach ($kwitansi as $kw) { ?>
                                            <option value="<?= $kw->kw_nomor ?>"><?= $kw->kw_nomor; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="div_jumlah">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" id="jpt_jml_pecahan" name="jpt_jml_pecahan" class="form-control" value="" readonly>
                                </div>
                            </div>
                            <?php
                            $no = 0;
                            foreach ($pecahan as $pc) {
                                $no++;
                            ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label><?= $pc->pec_jenis ?> Rp. <?= number_format($pc->pec_nilai, 0, ",", "."); ?></label>
                                        <input type="number" min=0 class="form-control inputPecahan pecahan_uang_<?= $pc->pec_jenis; ?>_<?= $pc->pec_nilai; ?>" id="nilai_pecahan<?= $no; ?>" nilai=<?= $pc->pec_nilai; ?> name="nilai_pecahan[<?= $pc->pec_id; ?>]" value="">
                                    </div>
                                </div>
                            <?php
                            } ?>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea type="text" rows="5" id="catatan" name="jpt_catatan" class="ckeditor"></textarea>
                                </div>
                            </div>
                            <input type="hidden" id="jmlPecahan" value=<?= $no; ?>>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="jpt_simpan" class="btn btn-success">Simpan</button>
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

function simpan_ket(id,val)
{
    if (event.keyCode == 13)
    {
        $.post("<?= base_url("Penjemputan/simpan_ket");?>",{id:id,val:val}, function(res)
        {
            if (res == 1)
            {
                toastr.success("Keterangan berhasil disimpan");
            }
            else
            {
                toastr.error("Keterangan gagal disimpan");
            }
        });
    }
}

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
</script>