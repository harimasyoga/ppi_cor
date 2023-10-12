<?php
$setting = $this->db->query("SELECT * FROM m_setting")->row();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $setting->nm_aplikasi ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?= base_url('assets/gambar/') . $setting->logo ?>">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">

	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<!-- Toastr -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/toastr/toastr.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/customFont.css" rel="stylesheet">

	<!-- jQuery -->
	<script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item">
					<?= $this->session->userdata('username') ?> , <a href="#"><?= $this->session->userdata('level') ?></a>
				</li>
			</ul>


			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Messages Dropdown Menu -->
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" href="<?= base_url('Login/logout') ?>">
						Logout
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
						<i class="fas fa-th-large"></i>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<!-- <a href="<?= base_url('assets/') ?>index3.html" class="brand-link">
      <img src="<?= base_url('assets/') ?>dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sistem Cost</span>
    </a> -->

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<!-- <img src="<?= base_url('assets/') ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
					</div>
					<div class="info">
						<a href="<?= base_url('Master') ?>" class="d-block">
							<h2><?= $setting->singkatan ?></h2>
						</a>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
						<li class="nav-item has-treeview">
							<a href="<?= base_url('Master') ?>" class="nav-link">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>
						<?php if (in_array($this->session->userdata('level'), ['Admin','Marketing'])): ?>
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									Master
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">

								<?php if ($this->session->userdata('level') == 'Admin' || $this->session->userdata('level') == 'Marketing') : ?>
									<li class="nav-item">
										<a href="<?= base_url('Master/Produk') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Produk</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= base_url('Master/Pelanggan') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Pelanggan</p>
										</a>
									</li>
								<?php endif ?>

								<?php if ($this->session->userdata('level') == 'Admin') : ?>
									<li class="nav-item">
										<a href="<?= base_url('Master/User') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>User</p>
										</a>
									</li>
								<?php endif ?>
							</ul>
						</li>
						<?php endif ?>

						<?php if (in_array($this->session->userdata('level'), ['Admin','User'])) : ?>
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-edit"></i>
								<p>
									Transaksi
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">

								
									<li class="nav-item">
										<a href="<?= base_url('Transaksi/PO') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>PO</p>
										</a>
									</li>

									<li class="nav-item">
										<a href="<?= base_url('Transaksi/SO') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>SO</p>
										</a>
									</li>

									<li class="nav-item">
										<a href="<?= base_url('Transaksi/WO') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>WO</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= base_url('Transaksi/SuratJalan') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Surat Jalan</p>
										</a>
									</li>

							</ul>
						</li>
						<?php endif ?>

						<?php if (in_array($this->session->userdata('level'), ['Admin','Marketing','PPIC','Owner'])): ?>
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-edit"></i>
								<p>
									Approval
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">

								
									<li class="nav-item">
										<a href="<?= base_url('Transaksi/PO') ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>PO</p>
										</a>
									</li>

							</ul>
						</li>
						<?php endif ?>
						<!-- <li class="nav-item has-treeview">
            <a href="<?= base_url('Laporan') ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                laporan
              </p>
            </a>
            
          </li> -->
						<!--  <li class="nav-header">Pengaturan</li>
          <li class="nav-item has-treeview">
            <a href="<?= base_url('Master/Sistem') ?>" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>
                Sistem
              </p>
            </a>
            
          </li> -->

					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>
