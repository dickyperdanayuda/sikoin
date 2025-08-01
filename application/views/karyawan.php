<div class="inner">
	<div class="row">
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:tambah()" class="btn btn-success btn-block"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
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
					Data Karyawan
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-karyawan" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Jenis Kelamin</th>
								<th>Telp</th>
								<th>WhatsApp</th>
								<th>Alamat</th>
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
<div class="modal fade" id="modal_karyawan" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Karyawan</h3>
			</div>
			<form role="form  col-lg-6" name="Karyawan" id="frm_karyawan">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="kry_id" name="kry_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama</label>
								<input type="text" required="required" class="form-control" name="kry_nama" id="kry_nama" placeholder="Nama">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>No. Telp</label>
								<input type="text" required="required" class="form-control" name="kry_telp" id="kry_telp" placeholder="Telp">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>WhatsApp</label>
								<input type="text" required="required" class="form-control" name="kry_wa" id="kry_wa" placeholder="WhatsApp">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tempat Lahir</label>
								<input type="text" required="required" class="form-control" name="kry_tempat_lahir" id="kry_tempat_lahir" placeholder="Tempat Lahir">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input type="text" required="required" class="form-control tgl" name="kry_tgl_lahir" id="kry_tgl_lahir" autocomplete="off">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="kry_jk" id="kry_jk">
									<option value=1>Laki-laki</option>
									<option value=2>Perempuan</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Alamat</label>
								<textarea class="form-control" type="text" required="required" name="kry_alamat" id="kry_alamat" placeholder="Alamat"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="kry_simpan" class="btn btn-success">Simpan</a>
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
<script src="<?= base_url("assets/"); ?>dist/js/karyawan.js"></script>