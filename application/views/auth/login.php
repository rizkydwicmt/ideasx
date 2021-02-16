<?php
defined('BASEPATH') or exit('No direct script access allowed');

?>

<!-- BEGIN #page-container -->
<div id="page-container" class="fade">
    <!-- BEGIN login -->
    <div class="login">
        <!-- BEGIN login-cover -->
        <div class="login-cover"></div>
        <!-- END login-cover -->
        <!-- BEGIN login-content -->
        <div class="login-content">
            <!-- BEGIN login-brand -->
            <div class="login-brand">
                <a href="#"><span class="logo"><i class="ti-infinite"></i></span> iDeas System</a>
                <?= $this->session->flashdata('message'); ?>
            </div>
            <!-- END login-brand -->
            <!-- BEGIN login-desc -->
            <div class="login-desc">
                For your protection, please verify your identity.
            </div>
            <!-- END login-desc -->
            <!-- BEGIN login-form -->
            <form method="POST" name="login_form" action="<?= base_url('auth'); ?>">
                <div class="form-group">
                    <label class="control-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= set_value('username'); ?>" autocomplete="off">
                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="m-b-10">
                    <a href="#" class="pull-left">Forgot your ID or password?</a>
                    <br>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
            <!-- END login-form -->
            <div class="m-t-20">
                Not a member yet? <a href="<?= base_url('auth/registration'); ?>">Get an iDeas ID</a>
            </div>
        </div>
        <!-- END login-content -->
    </div>
    <!-- END login -->

    <!-- BEGIN btn-scroll-top -->
    <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
    <!-- END btn-scroll-top -->
</div>
<!-- END #page-container -->