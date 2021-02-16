<!-- BEGIN #page-container -->
<div id="page-container" class="page-header-fixed page-sidebar-fixed fade">
    <!-- BEGIN #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- BEGIN container-fluid -->
        <div class="container-fluid">
            <!-- BEGIN mobile sidebar expand / collapse button -->
            <div class="navbar-header">
                <a href="index.html" class="navbar-brand">
                    <i class="ti-infinite navbar-logo text-gradient bg-gradient-blue-purple"></i>
                    <b>iDeas</b> | IntegrateD Enterprise Application System
                </a>

            </div>
            <!-- END mobile sidebar expand / collapse button -->
            <!-- BEGIN header navigation right -->
            <div class="navbar-xs-justified">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown">
                            <span class="navbar-user-img online pull-left">
                                <img src="<?= base_url(); ?>/img_user/<?= $user['image']; ?>" alt="" />
                            </span>
                            <span class="hidden-xs "><?= $this->session->userdata('fullname') ?> <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= base_url('admin/Profile'); ?>">Edit Profile</a></li>
                            <li><a href="javascript:;">Setting</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= base_url('auth/logout'); ?>">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END header navigation right -->
        </div>
        <!-- END container-fluid -->
    </div>
    <!-- END #header -->