<body class="inverse-mode">
    <!-- BEGIN #page-container -->
    <div id="page-container" class="fade">
        <!-- BEGIN register -->
        <div class="register">
            <!-- BEGIN register-cover -->
            <div class="register-cover"></div>
            <!-- END register-cover -->
            <!-- BEGIN register-content -->
            <div class="register-content">
                <!-- BEGIN register-brand -->
                <div class="register-brand">
                    <a href="#"><span class="logo"><i class="ti-infinite"></i></span> iDeas System</a>
                </div>
                <!-- END register-brand -->
                <h3 class="m-b-20"><span>Sign Up</span></h3>
                <p class="m-b-20">One iDeas ID is all you need to access all the iDeas system.</p>
                <!-- BEGIN register-form -->
                <form action="<?= base_url('auth/registration') ?>" method="POST" name="register_form">
                    <!-- BEGIN row -->
                    <div class="row row-space-20">
                        <!-- BEGIN col-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">User Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= set_value('username') ?>" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" />
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="passoword" name="password" placeholder="Password" value="" />
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="repassoword" name="repassword" placeholder="Confirm Password" value="" />
                            </div>
                        </div>
                        <!-- END col-6 -->
                        <!-- BEGIN col-6 -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="control-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" value="<?= set_value('fullname') ?>" />
                                <?= form_error('fullname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Departement <span class="text-danger">*</span></label>
                                <select class="form-control">
                                    <option>United States</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Position <span class="text-danger">*</span></label>
                                <select class="form-control">
                                    <option>Female</option>
                                </select>
                            </div>

                        </div>
                        <!-- END col-6 -->
                    </div>
                    <!-- END row -->
                    <div class="m-b-10 m-t-10">
                        <div class="checkbox-inline">
                            <input type="checkbox" id="login-remember-me" value="2"> <label for="login-remember-me">I have read and agree to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                    <div class="m-t-20">
                        Already have an iDeas ID? <a href="<?= base_url('auth'); ?>">Sign In</a>
                    </div>
                </form>
                <!-- END register-form -->
            </div>
            <!-- END register-content -->
        </div>
        <!-- END register -->

        <!-- BEGIN btn-scroll-top -->
        <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
        <!-- END btn-scroll-top -->
    </div>
    <!-- END #page-container -->