<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DOrSU - Course Completion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="assets/dist/img/dorsu.png">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/dist/css/style.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php 
            include("database/DBConnection.php");
            global $conn;
            include("containers/sidebar.php");
        ?>
        <input type="hidden" id="page" value="6">
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <div class="main-container">
                <div class="container-fluid row">
                    <?php
                        $getCourse = $conn->query("SELECT * FROM course");
                        while($course = $getCourse->fetch_assoc()){
                            $getCount = $conn->query("SELECT * FROM curriculum WHERE course_id = ".$course['id']." ORDER BY number DESC LIMIT 1");
                            while($count = $getCount->fetch_assoc()){
                                echo '<div class="col-lg-3 col-6 box">
                                <a href="curriculumlist.php?course='.$course['id'].'&des='.$course['name'].'&curnum='.$count['number'].'" id="'.$course['id'].'">
                                    <div class="small-box bg-course">
                                        <div class="inner">
                                            <h4>'.$course['name'].'</h4>
                                            <p>Curriculum</p>
                                        </div>
                                    </div>
                                </a>
                                </div>';
                            }
                        }
                    ?>
                </div>
            </div>

        </div>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>

    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/dist/js/validation.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/pages/adminlte.min.js"></script>

</body>

</html>