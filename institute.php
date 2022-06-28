<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DOrSU - Course Completion</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/dist/img/projectred.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/dist/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <?php 
                include("database/DBConnection.php");
                global $conn;
                include("containers/sidebar.php");
            ?>
        <input type="hidden" id="page" value="1">
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            </section>

            <div class="row" style="margin: 0px 10px 0px 10px;">
                <div class="col-12 col-sm-6 col-md-6">
                    <a href="course.php">
                        <div class="info-box" style="border: 3px solid #17a2b8">
                            <span class="info-box-icon bg-info elevation-1">
                            <i class="nav-icon fab fa-discourse"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Course</span>
                                <span class="info-box-number">
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-6">
                    <a href="subject.php">
                        <div class="info-box mb-3" style="border: 3px solid #dc3545">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="nav-icon fas fa-book"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Subject</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-6">
                    <a href="enrollment.php">
                        <div class="info-box mb-3" style="border: 3px solid #28a745">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="nav-icon fas fa-user-edit"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Enrollment</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-6">
                    <a href="curriculum.php">
                        <div class="info-box mb-3" style="border: 3px solid #ffc107">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Curriculum</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-12">
                    <a href="grades.php">
                        <div class="info-box mb-3" style="border: 3px solid rgb(151, 151, 151)">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="nav-icon fas fa-chart-line"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Grades</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/pages/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/dist/js/demo.js"></script>

</body>

</html>