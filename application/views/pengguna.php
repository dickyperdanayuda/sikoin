<div class="inner">
	<div class="row">
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:log_tambah()" class="btn btn-success btn-block"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
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
					Data Pengguna
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-pengguna" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Username</th>
								<th>Level</th>
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
<div class="modal fade" id="modal_pengguna" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Pengguna</h3>
			</div>
			<form role="form  col-lg-6" name="Pengguna" id="frm_pengguna">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="log_id" name="log_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Karyawan</label>
								<select class="form-control" required="" name="log_kry_id" id="log_kry_id">
									<option value="">== Pilih ==</option>
									<?php foreach ($karyawan as $kry) { ?>
										<option value="<?= $kry->kry_id ?>"><?= $kry->kry_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!-- <div class="col-lg-6">
							<div class="form-group">
								<label>Nama Pengguna</label>
								<input type="text" class="form-control" name="log_nama" id="log_nama" placeholder="">
							</div>
						</div> -->
						<div class="col-lg-6">
							<div class="form-group">
								<label>Username</label>
								<input type="text" required="" class="form-control" name="log_username" id="log_username" placeholder="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Password</label>
								<input type="password"  class="form-control" name="log_password" id="log_password" placeholder="Password">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Level</label>
								<select class="form-control" required="" name="log_level" id="log_level">
									<option value="">== Pilih ==</option>
									<option value=2>Admin</option>
									<option value=3>Petugas</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="log_simpan" class="btn btn-success">Simpan</button>
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
<script src="<?= base_url("assets/"); ?>dist/js/pengguna.js"></script>