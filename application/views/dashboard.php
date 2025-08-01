<?php
// File Size 
function file_size($size)
{
	$ms = "B";
	$sz = number_format($size, 2, ",", ".");
	if ($size > 1024) {
		$sz = number_format($size / 1024, 2, ",", ".");
		$ms = "KB";
	}
	if ($size > 1048576) {
		$sz = number_format($size / 1048576, 2, ",", ".");
		$ms = "MB";
	}
	if ($size > 1073741824) {
		$sz = number_format($size / 1073741824, 2, ",", ".");
		$ms = "GB";
	}
	if ($size > 1099511627776) {
		$sz = number_format($size / 1099511627776, 2, ",", ".");
		$ms = "TB";
	}
	return "{$sz} {$ms}";
}
?>
<div class="container">
	<div class="row">
		<?php if ($this->session->userdata('level') < 3) { ?>
			<div class="col-md-3 col-sm-6 col-12">
				<div class="info-box">
					<span class="info-box-icon bg-success"><i class="fas fa-building"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Jumlah Donatur</span>
						<span class="info-box-number"><?= number_format($donatur, 0, ",", "."); ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-12">
				<div class="info-box">
					<span class="info-box-icon bg-success"><i class="fas fa-box"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Jumlah Kotak</span>
						<span class="info-box-number"><?= number_format($kotak, 0, ",", "."); ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-12">
				<div class="info-box">
					<span class="info-box-icon bg-success"><i class="fas fa-box"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Jumlah Kotak Keluar</span>
						<span class="info-box-number"><?= number_format($kotakkeluar, 0, ",", "."); ?></span>
					</div>
				</div>
			</div>
			<!-- /.col -->
		<?php } ?>

		<?php if ($this->session->userdata('level') > 2) { ?>
			<div class="col-md-3 col-sm-6 col-12">
				<div class="info-box">
					<span class="info-box-icon bg-success"><i class="fas fa-calendar"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Jumlah Tugas</span>
						<span class="info-box-number"><?= number_format($penugasan, 0, ",", "."); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<div class="col-md-3 col-sm-6 col-12">
				<div class="info-box">
					<span class="info-box-icon bg-success"><i class="fas fa-file"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Jumlah Kwitansi</span>
						<span class="info-box-number"><?= number_format($kwitansi, 0, ",", "."); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		<?php } ?>
	</div>
</div>

<!-- Custom Java Script -->
<script src="<?= base_url("assets/"); ?>dist/js/dashboard.js"></script>