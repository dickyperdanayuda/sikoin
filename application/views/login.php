<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login | Sistem Pengelolaan Kotak Infaq (SI)</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/dist/css/adminlte.min.css">
	<!-- Toastr -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<style>
	body {
		display: flex;
		align-items: center;
	}
</style>

<body class="hold-transition login-page" style="text-align:right;background-image:url(<?= base_url("assets/dist/img/"); ?>);background-size:cover;background-repeat:no-repeat;">
	<input type="hidden" id="base_link" value="<?= base_url(); ?>">
	<div class="container mr-5">
		<!-- <div class="container" style="margin-right: 500px;"> -->
		<!-- <div class="login-box" style="margin-left: 715px; margin-top: 130px;"> -->
		<div class="ml-auto login-box">
			<!-- /.login-logo -->
			<div class="card">
				<div class="login-logo card-header">
					<a href="<?= base_url(); ?>"><b>Login DRT</b></a>
				</div>
				<div class="card-body login-card-body pt-30">
					<p class="login-box-msg">Pengelolaan Kotak Infaq DRT</p>

					<form action="<?= base_url("Login/proses"); ?>" method="post" id="frm_login">
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="username" placeholder="Username" required>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						<div class="input-group mb-3">
							<input type="password" class="form-control" name="password" placeholder="Password" required>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<!-- /.col -->
							<div class="col-lg-12">
								<button type="submit" class="btn btn-primary btn-block">Masuk</button>
							</div>
							<!-- /.col -->
						</div>
					</form>

				</div>
				<!-- /.login-card-body -->
			</div>
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?= base_url("assets"); ?>/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url("assets"); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url("assets"); ?>/dist/js/adminlte.min.js"></script>
	<!-- Toastr -->
	<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>
	<!-- Custom -->
	<script src="<?= base_url("assets"); ?>/dist/js/login.js"></script>

</body>

</html>