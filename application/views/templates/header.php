<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>iDeas | <?= $tittle ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="<?= base_url('assets/'); ?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>plugins/bootstrap/bootstrap4/css/bootstrap.min.css" rel="stylesheet" />

    <link href="<?= base_url('assets/'); ?>plugins/icon/themify-icons/themify-icons.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>css/animate.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>css/style.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!--Font Awesome WebFont CSS for icons-->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/fontawesome-free/css/fontawesome.css" />

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?= base_url('assets/'); ?>plugins/loader/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN EASYUI ================== -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/<?= $user['tipe']; ?>/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/icon.css">

    <!-- ================== END EASYUI ================== -->

    <!-- ================== BEGIN EASYUI ================== -->
    <script src="<?= base_url('assets/'); ?>plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('assets/easyui/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/easyui/jquery.easyui.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/easyui/plugins/') ?>datagrid-detailview.js"></script>
    <style type="text/css">
        .datagrid-footer .datagrid-row {
            background: #ddd;
        }
    </style>
    <!-- ================== END EASYUI ================== -->

    <!-- ================== BEGIN VALIDATE JS ================== -->
    <script src="<?= base_url('assets/'); ?>js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/sweetalert2.min.css">
    <!-- ================== END VALIDATE JS ================== -->

    <link href="<?= base_url('assets/'); ?>plugins/table/DataTables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="<?= base_url('assets/'); ?>plugins/table/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/'); ?>plugins/table/DataTables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>