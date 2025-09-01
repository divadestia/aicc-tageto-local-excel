<!doctype html>
<html lang="en">

<head>
    <?php
    $this->load->view('back_partial/title-meta');
    $this->load->view('back_partial/head-css');
    ?>
    <!--Jquery Inline -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <link href="<?php echo base_url(); ?>assets_back/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets_back/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets_back/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
</head>


<body data-topbar="dark">
    <!-- ==== NavBar Section ==== -->
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="livetable" class="logo logo-light">
                        <span class="logo-lg">
                            <img src="<?php echo base_url() ?>file/logo/logo-light.png" alt="Asia Isuzu Casting Center" height="45">
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
    <!-- ==== End NavBar Section ==== -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <?php
            $this->load->view('back_partial/page-title.php');
            ?>
            <!-- ======= FORM AREA ======= -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-data" method="POST">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="process_date" class="form-label">Process Date</label>
                                        <input type="date" class="form-control" id="process_date" name="process_date" placeholder="Enter Process Date" autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="charging_date" class="form-label">Charging Date</label>
                                        <input type="text" class="form-control" id="charging_date" name="charging_date" placeholder="Enter Charging Date" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="row align-items-end mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Type Product</label>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            <!-- Radio Buttons -->
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="product_type" value="4JA1" autocomplete="off"> 4JA1
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="product_type" value="C240" autocomplete="off"> C240
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="product_type" value="EJ39" autocomplete="off"> EJ39
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="product_type" value="EJ40" autocomplete="off"> EJ40
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="product_type" value="EJ59" autocomplete="off"> EJ59
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="product_type" value="ES01" autocomplete="off"> ES01
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="product_type" value="ES30" autocomplete="off"> ES30
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus"></i> Add Data</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <input type="hidden" name="gabari" id="gabari_hidden" value="No">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirm_check">
                                            <label class="form-check-label" for="confirm_check">
                                                Gabari Check
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======= END FORM AREA ======= -->

            <!-- ======= INLINE TABLE AREA ======= -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p></p>
                            <div style="max-width: 100%; overflow-x: auto;">
                                <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center align-middle" rowspan="2">No</th>
                                            <th class="text-center align-middle" rowspan="2">Charging Date</th>
                                            <th class="text-center align-middle" rowspan="2">Type Product</th>
                                            <th class="text-center align-middle" rowspan="2">No Core</th>
                                            <th class="text-center align-middle" rowspan="2">Pola</th>
                                            <th class="text-center align-middle" colspan="2">Process 1</th>
                                            <th class="text-center align-middle" colspan="2">Process 2</th>
                                            <th class="text-center align-middle" colspan="1">Process 3</th>
                                            <th class="text-center align-middle" rowspan="2">Oil Pump</th>
                                            <th class="text-center align-middle" rowspan="2">Kijun Bosu 3</th>
                                            <th class="text-center align-middle" rowspan="2">Bosu Cope</th>
                                            <th class="text-center align-middle" rowspan="2">By Gauge</th>
                                            <th class="text-center align-middle" rowspan="2">Proses #2</th>
                                            <th class="text-center align-middle" rowspan="2">Sampling<p>1/20 Pcs</p>
                                            </th>
                                            <th class="text-center align-middle" rowspan="2" style="min-width: 100px;">Remark</th>
                                            <th class="text-center align-middle" rowspan="2">Gabari Check</th>
                                            <th class="text-center align-middle" rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center align-middle" style="min-width: 100px;">A</th>
                                            <th class="text-center align-middle" style="min-width: 100px;">B</th>
                                            <th class="text-center align-middle" style="min-width: 100px;">C</th>
                                            <th class="text-center align-middle" style="min-width: 100px;">D</th>
                                            <th class="text-center align-middle" style="min-width: 100px;">E</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- OUPUT NILAI TABLE  -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ======= END INLINE TABLE AREA ======= -->
        </div> <!-- end row -->
    </div>

    <!-- ======= NUMPAD AREA ======= -->
    <div id="numpadContainer" class="bg-white border rounded shadow p-22" style="position:absolute; display:none; z-index:9999; width:220px;">
        <input type="text" id="numpadDisplay" class="form-control text-center fw-bold fs-5 mb-3 bg-light" readonly>

        <div class="d-flex flex-wrap justify-content-center">

            <!-- Line 1 -->
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('D')">D</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('S')">S</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('N')">N</button>

            <!-- Line 1 -->
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('7')">7</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('8')">8</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('9')">9</button>


            <!-- Line 2 -->
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('4')">4</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('5')">5</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('6')">6</button>

            <!-- Line 3 -->
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('1')">1</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('2')">2</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('3')">3</button>

            <!-- Line 4 -->
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('0')">0</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="np('.')">.</button>
            <button class="btn btn-light m-1 fw-bold" style="width:60px;" onclick="tn()">±</button>

            <!-- Line 5 -->
            <button class="btn btn-danger m-1 fw-bold" style="width:60px;" onclick="clearNp()">Clear</button>
            <button class="btn btn-dark m-1 fw-bold" style="width:60px;" onclick="cancelNp()">Cancel</button>
            <button class="btn btn-success m-1 fw-bold" style="width:60px;" onclick="okNp()">Save</button>
        </div>
    </div>
    <!-- ======= END NUMPAD AREA ======= -->

    <!-- ========== NOTIFICATION ========= -->
    <div id="toastNotif" class="toast position-fixed" style="top: 1rem; right: 1rem; z-index: 9999; min-width: 300px;" data-delay="4000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white" style="font-size: 1.2rem; padding: 0.75rem 1rem;">
            <strong id="toast-title" class="mr-auto font-weight-bold">Sucess</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" style="font-size: 1.5rem;">&times;</button>
        </div>
        <div class="toast-body bg-white text-dark" id="toast-body" style="font-size: 1.1rem; padding: 1rem;">
        </div>
    </div>
    <!-- ========== NOTIFICATION ========= -->

    <!-- ========== FOOTER ========= -->
    <footer class="bg-white text-center align-middle" style="height:60px; padding:20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-sm-center d-none d-sm-block">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © All Rights Reserved - PT Asian Isuzu Casting Center
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ========== END FOOTER ========= -->

    <!-- JAVASCRIPT  -->
    <?php $this->load->view('back_partial/vendor-scripts') ?>
    <!-- Required datatable js -->
    <script src="<?php echo base_url() ?>assets_back/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>assets_back/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>assets_back/js/app.js"></script>
    <?php
    $this->load->view('live_table_js');
    ?>
</body>

</html>