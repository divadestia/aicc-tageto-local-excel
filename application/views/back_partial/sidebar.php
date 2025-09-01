<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="<?php echo base_url() ?>dashboard" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-title">Master</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=" ri-archive-drawer-line"></i>
                        <span>Master</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="<?php echo base_url() ?>master/customer"><i class="ri-focus-line"></i>Data Customer</a></li>
                        <li><a href="<?php echo base_url() ?>master/subcont"><i class="ri-focus-line"></i>Data Subcont</a></li>
                        <li><a href="<?php echo base_url() ?>master/karyawan"><i class="ri-focus-line"></i>Data Karyawan</a></li>
                        <li><a href="<?php echo base_url() ?>master/tageto"><i class="ri-focus-line"></i>Tageto</a></li>
                        <li><a href="<?php echo base_url() ?>LiveTable"><i class="ri-focus-line"></i>Data Inline</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->