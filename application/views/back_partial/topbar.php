<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img class="img-fluid" src="<?php echo base_url() ?>file/logo/logo-sm.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url() ?>file/logo/logo-light.png" alt="" height="45">
                    </span>
                </a>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?php echo base_url() ?>assets_back/images/users/avatar-2.jpg" alt="Header Avatar">
                    <span class=" d-xl-inline-block ml-1"><?php echo $this->session->userdata('username') ?> </span>

                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <!-- <a href="<?php echo base_url() ?>profile" class="dropdown-item" href="#"><i class="ri-user-line align-middle mr-1"></i> Profile    -->
                    <a class="dropdown-item text-danger" href="<?php echo base_url() ?>logout"><i class="ri-shut-down-line align-middle mr-1 text-danger"></i> Logout</a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="ri-settings-2-line"></i>
                </button>
            </div>

        </div>
    </div>
</header>