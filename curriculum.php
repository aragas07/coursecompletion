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
        <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
    #loading {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background-color: #5a5a5a77;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sample-data-title {
        padding: 10px;
        border: 1px solid gray;
        border-radius: 3px;
        margin-bottom: 10px;
    }

    .sample-data-title>.img-title {
        margin-top: -24px;
        background-color: white;
        position: fixed;
        padding: 0 4px;
    }
    </style>
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
                    <a data-toggle="modal" data-target="#choices">
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

        <div class="modal fade" id="choices">
            <div class="modal-dialog modal-sm">
                <div class="modal-content p-3">
                    <div class="form-group">
                        <a class="btn btn-outline-secondary col-12"
                            href="addcurriculum.php?course=<?php echo $courseid?>">Manual</a>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-secondary col-12" data-toggle="modal"
                            data-target="#upl-csv">Upload CSV</button>
                    </div>
                    <button class="btn btn-outline-danger col-12" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="upl-csv">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Upload file</h4>
                        <button type="button" class="close" id="add-modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="upcsv" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="text-center">
                                <h2>File format for the column header</h2>
                                <p styl="font-size: 19px">Year, Sem, Course no., Description, Prerequisite</p>
                                <div class="sample-data-title">
                                    <div class="img-title">Sample data format</div>
                                    <img src="assets/dist/img/sample_curriculum.png" alt="sdf" class="col-12">
                                </div>
                            </div>
                            <input type="file" accept=".csv" class="form-control" name="curriculumfile">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                            <button id="change-course" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <div id="loading" hidden>
            <i class="fa fa-spinner fa-spin" style="font-size:72px; color: white"></i>
        </div>
        <!-- /.control-sidebar -->

    </div>
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
        <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/dist/js/pages/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/dist/js/demo.js"></script>
    <script>
        $(function(){
            $("#upcsv").submit(function(e) {
                e.preventDefault();
                $("#upl-csv").modal('hide');
                $("#choices").modal('hide');
                $("#loading").prop('hidden', false);
                $.ajax({
                    url: 'database/DBManipulation.php',
                    type: 'post',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                        console.log(result.sample);
                        if (result.success) {
                            toastr.success(result.response);
                            setTimeout(function() {
                                //location.reload();
                            }, 1300);
                        } else {
                            toastr.error(result.response);
                        }
                        $("#loading").prop('hidden', true);
                    },error: function (request, status, error) {
                        toastr.error(request.responseText);
                    }
                })
            })
        })
    </script>

</body>

</html>