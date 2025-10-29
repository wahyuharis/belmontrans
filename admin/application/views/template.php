<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= APP_NAME ?> | <?= $title_page ?></title>
    <link rel="icon" href="<?= base_url('img/harispos_logo_web.png') ?>" type="image/x-icon" />

    <?php require_once 'template_assets.php' ?>

    <script>
        function Custom_loading() {
            JsLoadingOverlay.show({
                "spinnerIcon": "ball-clip-rotate",
                "spinnerSize": "2x"
            });
        }
    </script>
</head>

<body class="hold-transition sidebar-mini pace-primary layout-navbar-fixed layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url('home') ?>" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <?= ucwords($this->session->userdata('username')) ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('profile') ?>">Profile</a>
                        <a class="dropdown-item" href="<?= base_url('profile/password') ?>">Password</a>
                        <a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a>
                    </div>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-light-primary">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link">
                <img src="<?= base_url(APP_LOGO) ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= APP_NAME ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('lte') ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= ucwords($this->session->userdata('username')) ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group">
                        <input id="side_filter" class="form-control form-control-sidebar" type="text" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="sidebar-menu nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <?php require_once "template_sidemenu.php" ?>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?= $title_page ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <!-- <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Pace</li>
                            </ol> -->
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>


            <!-- Main content -->
            <section class="content">
                <?php if (isset($content)) echo $content ?>
            </section>
            <!-- /.content -->


            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2025-2026 <a href="https://adminlte.io">Belmontransport.com</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?= base_url('lte') ?>/dist/js/adminlte.min.js"></script>
    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        $(document).ready(function() {

            <?php if (strlen($this->session->flashdata('error_message')) > 0) { ?>

                toastr.error('<?= $this->session->flashdata('error_message') ?>', 'Maaf');

            <?php } ?>

            <?php if (strlen($this->session->flashdata('success_message')) > 0) { ?>

                toastr.success('<?= $this->session->flashdata('success_message') ?>', 'Info');

            <?php } ?>


            $("#side_filter").on('keyup change', function(e) {
                var filter = $(this).val(),
                    count = 0;

                $('.sidebar-menu').find('li').each(function() {
                    if (filter == "") {
                        $(this).css("visibility", "visible");
                        $(this).fadeIn();
                    } else if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).css("visibility", "hidden");
                        $(this).fadeOut();
                    } else {
                        $(this).css("visibility", "visible");
                        $(this).fadeIn();
                    }
                });
            });

        });
    </script>
</body>

</html>