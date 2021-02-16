<!-- BEGIN #sidebar ---------------------------------------------------------------------->
<div id="sidebar" class="sidebar sidebar-inverse">
    <!-- BEGIN scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- BEGIN nav -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <img src="<?= base_url(); ?>/img_user/<?= $user['image']; ?>" />
                </div>
                <div class="info">
                    <h4><?= $user['full_name']; ?></h4>
                    <p><?= $user['user_position']; ?></p>
                </div>

            </li>

            <!--------------------------------------------->
            <!-- QUERY MENU LVL 0 -->

            <?php
            // $curl = $this->uri->segment(1);  // get active URL to set active menu 
            $curl = strtoupper($curlx); // get active URL to set active menu 
            $role_id = $this->session->userdata('role');

            if (strtolower($role_id) == 'admin') {

                $qrym0 = "SELECT * 
                            FROM master.menu_web 
                            WHERE isactive='1' AND lvl=0 
                            ORDER BY menu_id ASC";

                $menu0 = $this->db->query($qrym0)->result_array();
            ?>
                <!-- LOOPING menu level 0 -->
                <?php foreach ($menu0 as $m0) : ?>
                    <li class="nav-divider"></li>
                    <li class="nav-header"><?= $m0['menu_name']; ?></li>

                    <!-- QUERY MENU LVL 1 -->
                    <?php
                    $qrym1 = "SELECT *, upper(url_active) as urla
                                FROM master.menu_web 
                                WHERE isactive='1' AND lvl=1 AND parent_id= $m0[menu_id]
                                ORDER BY menu_id ASC";
                    $menu1 = $this->db->query($qrym1)->result_array();
                    ?>
                    <!-- LOOPING menu level 1 -->
                    <?php foreach ($menu1 as $m1) :
                        if ($m1['isdetail'] == '1') {
                            if ($m1['urla'] == $curl) { ?>
                                <li class="active"><a href="<?= base_url($m1['url']); ?>"><i class="<?= $m1['icon']; ?>"></i><span><?= $m1['menu_name']; ?></span></a></li>
                            <?php
                            } else { ?>
                                <li><a href="<?= base_url($m1['url']); ?>"><i class="<?= $m1['icon']; ?>"></i><span><?= $m1['menu_name']; ?></span></a></li>
                            <?php
                            }
                        } elseif ($m1['isdetail'] == '0') { ?>
                            <!-- cek active menu or not -->
                            <?php

                            $qryc = $this->db->get_where('master.menu_web', ['url_active' => $curlx])->num_rows();
                            if ($qryc > 0) {
                                $qryp = $this->db->get_where('master.menu_web', ['url_active' => $curlx])->row_array();
                                $mparent_id = $qryp['parent_id'];
                            } else {
                                $mparent_id = '';
                            };


                            if ($m1['menu_id'] == $mparent_id) { ?>

                                <li class="has-sub active">
                                <?php
                            } else { ?>
                                <li class="has-sub">
                                <?php
                            } ?>
                                <a href="javascript:;">
                                    <b class="caret caret-right pull-right"></b>
                                    <i class="<?= $m1['icon']; ?>"></i>
                                    <span><?= $m1['menu_name']; ?></span>
                                </a>
                                <ul class="sub-menu">
                                    <!-- QUERY MENU LVL 2 -->
                                    <?php
                                    $qrym2 = "SELECT * 
                                                FROM master.menu_web 
                                                WHERE isactive='1' AND lvl=2 AND parent_id= $m1[menu_id]
                                                ORDER BY menu_id ASC";
                                    $menu2 = $this->db->query($qrym2)->result_array();
                                    ?>
                                    <!-- LOOPING menu level 2 -->
                                    <?php foreach ($menu2 as $m2) :
                                        if ($m2['url'] == $curl) { ?>
                                            <li class="active"><a href="<?= base_url($m2['url']); ?>"><?= $m2['menu_name']; ?></a></li>
                                        <?php
                                        } else { ?>
                                            <li><a href="<?= base_url($m2['url']); ?>"><?= $m2['menu_name']; ?></a></li>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                    <!-- END LOOPING menu level 2 -->
                                </ul>
                                </li>
                            <?php
                        }
                            ?>
                        <?php endforeach; ?>
                        <!-- END LOOPING menu level 1 -->
                    <?php endforeach; ?>
                    <!-- END LOOPING menu level 0 -->
                <?php
            } elseif (strtolower($role_id) == 'user') {
                $qrym0 = "SELECT * 
                            FROM master.vuser_menu_web 
                            WHERE vuser='" . $this->session->userdata('username') . "' AND lvl=0  AND isbrowse='1'
                            ORDER BY imenu ASC";

                $menu0 = $this->db->query($qrym0)->result_array();
                ?>
                    <!-- LOOPING menu level 0 -->
                    <?php foreach ($menu0 as $m0) : ?>
                        <li class="nav-divider"></li>
                        <li class="nav-header"><?= $m0['menu_name']; ?></li>

                        <!-- QUERY MENU LVL 1 -->
                        <?php
                        $qrym1 = "SELECT *, upper(url_active) as urla
                                FROM master.vuser_menu_web 
                                WHERE vuser='" . $this->session->userdata('username') . "' AND lvl=1 and isbrowse='1'
                                    AND parent_id= $m0[imenu]
                                ORDER BY imenu ASC";
                        $menu1 = $this->db->query($qrym1)->result_array();
                        ?>
                        <!-- LOOPING menu level 1 -->
                        <?php foreach ($menu1 as $m1) :
                            if ($m1['isdetail'] == '1') {
                                if ($m1['urla'] == $curl) { ?>
                                    <li class="active"><a href="<?= base_url($m1['url']); ?>"><i class="<?= $m1['icon']; ?>"></i><span><?= $m1['menu_name']; ?></span></a></li>
                                <?php
                                } else { ?>
                                    <li><a href="<?= base_url($m1['url']); ?>"><i class="<?= $m1['icon']; ?>"></i><span><?= $m1['menu_name']; ?></span></a></li>
                                <?php
                                }
                            } elseif ($m1['isdetail'] == '0') { ?>
                                <!-- cek active menu or not -->
                                <?php

                                $qryc = $this->db->get_where('master.vuser_menu_web', ['url_active' => $curlx])->num_rows();
                                if ($qryc > 0) {
                                    $qryp = $this->db->get_where('master.vuser_menu_web', ['url_active' => $curlx])->row_array();
                                    $mparent_id = $qryp['parent_id'];
                                } else {
                                    $mparent_id = '';
                                };


                                if ($m1['imenu'] == $mparent_id) { ?>

                                    <li class="has-sub active">
                                    <?php
                                } else { ?>
                                    <li class="has-sub">
                                    <?php
                                } ?>
                                    <a href="javascript:;">
                                        <b class="caret caret-right pull-right"></b>
                                        <i class="<?= $m1['icon']; ?>"></i>
                                        <span><?= $m1['menu_name']; ?></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <!-- QUERY MENU LVL 2 -->
                                        <?php
                                        $qrym2 = "SELECT * 
                                                FROM master.vuser_menu_web 
                                                WHERE vuser='" . $this->session->userdata('username') . "' AND lvl=2 AND isbrowse='1'
                                                        AND parent_id= $m1[imenu]
                                                ORDER BY imenu ASC";
                                        $menu2 = $this->db->query($qrym2)->result_array();
                                        ?>
                                        <!-- LOOPING menu level 2 -->
                                        <?php foreach ($menu2 as $m2) :
                                            if ($m2['url'] == $curl) { ?>
                                                <li class="active"><a href="<?= base_url($m2['url']); ?>"><?= $m2['menu_name']; ?></a></li>
                                            <?php
                                            } else { ?>
                                                <li><a href="<?= base_url($m2['url']); ?>"><?= $m2['menu_name']; ?></a></li>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                        <!-- END LOOPING menu level 2 -->
                                    </ul>
                                    </li>
                                <?php
                            }
                                ?>
                            <?php endforeach; ?>
                            <!-- END LOOPING menu level 1 -->
                        <?php endforeach; ?>
                        <!-- END LOOPING menu level 0 -->
                    <?php

                }
                    ?>

                    <li class="nav-divider"></li>
                    <li class="nav-copyright">&copy; 2020 @Saridin Muhammadinov</li>
        </ul>
        <!-- END nav -->
    </div>
    <!-- END scrollbar -->
    <!-- BEGIN sidebar-minify-btn -->
    <a href="#" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ti-arrow-left"></i></a>
    <!-- END sidebar-minify-btn -->
</div>
<!-- END #sidebar -->