<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>iDeas |
        <?= $caption; ?>
    </title>
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="<?= base_url('assets/'); ?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>plugins/bootstrap/bootstrap4/css/bootstrap.min.css" rel="stylesheet" />

    <link href="<?= base_url('assets/'); ?>plugins/icon/themify-icons/themify-icons.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>css/animate.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>css/style.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->


    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/demo/demo.css">


    <script type="text/javascript" src="<?= base_url('assets/js'); ?>/number.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.edatagrid.js"></script>

</head>

<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- BEGIN container-fluid -->
    <div class="container-fluid">
        <!-- BEGIN mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <a href="<?= site_url() ?>" class="navbar-brand">
                <i class="ti-infinite navbar-logo text-gradient bg-gradient-blue-purple"></i>
                <b>iDeas</b> | IntegrateD Enterprise Application System
            </a>

        </div>
        <!-- END mobile sidebar expand / collapse button -->
        <!-- BEGIN header navigation right -->
        <div class="navbar-xs-justified">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a>
                        <span class="navbar-user-img online pull-left">
                            <img src="<?= base_url('assets/'); ?>/img/user.jpg" alt="" />
                        </span>
                        <span class="hidden-xs "><?= $this->session->userdata('fullname') ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END header navigation right -->
    </div>
    <!-- END container-fluid -->
</div>
<!-- END #header -->

<br>
<br>