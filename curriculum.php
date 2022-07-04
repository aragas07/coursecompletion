<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DOrSU - Course Completion</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/dist/img/dorsu.png">
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
            error_reporting(0);
        ?>
        <input type="hidden" id="page" value="1">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            </section>
            <h1 style="margin-left: 15px"><?php echo $_GET['des']?></h1>

            <div class="row" style="margin: 0px 10px 0px 10px;">
                <?php
                    $courseid = $_SESSION['courseId'];
                    $getCur = $conn->query("SELECT * FROM curriculum WHERE course_id = $courseid GROUP BY number ORDER BY number ASC");
                    while($row = $getCur->fetch_assoc()){
                        echo '<div class="col-lg-3 col-6 box t-center">
                            <a href="curriculumlist.php?curnum='.$row['number'].'&course='.$courseid.'&des='.$_GET['des'].'">
                                <div class="small-box bg-course">
                                    <div class="inner">
                                        <h4>Curriculum number '.$row['number'].'</h4>
                                    </div>
                                </div>
                            </a>
                        </div>';
                    }
                ?>
                <div class="col-lg-3 col-6 box t-center">
                    <a href="addcurriculum.php?course=<?php echo $courseid?>">
                        <div class="small-box bg-course">
                            <div class="inner">
                                <h4>Add Curriculum</h4>
                            </div>
                        </div>
                    </a>
                </div>
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