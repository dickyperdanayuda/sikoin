<div class="inner">
    <div class="row">
        <div class="col-md-2 col-xs-12">
            <div class="form-group">
                <input type="text" class="form-control range" id="filter_tanggal">
            </div>
        </div>
        <div class="col-md-2 col-xs-12">
            <div class="form-group">
                <a href="javascript:refresh()" class="btn btn-success btn-block"><i class="fa fa-refresh"></i> &nbsp;&nbsp;&nbsp; Refresh</a>
            </div>
        </div>
    </div>
    <div class="row" id="isidata">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Laporan Penjemputan Belum Divalidasi
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tabel-laporan" width="100%" style="font-size:120%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Validasi</th>
                                <th>User Hitung</th>
                                <th>Donatur</th>
                                <th>Nomor Kotak</th>
                                <th>Nomor Kwitansi</th>
                                <th>Jumlah Uang</th>
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
<script src="<?= base_url("assets/"); ?>dist/js/laporan.js"></script>