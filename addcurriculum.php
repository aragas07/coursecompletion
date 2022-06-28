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
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <div class="main-container">
                <div class="container-fluid">
                    <input type="hidden" id="coursenum">
                    <input type="hidden" id="course" value="<?php echo $_GET['course']?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-div">
                                <h2>1st year</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>First Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="fyfs" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dfyfs" class="col-md-12">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>Second Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="fyss" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dfyss" class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-div">
                                <h2>2nd year</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>First Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="syfs" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dsyfs" class="col-md-12">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>Second Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="syss" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dsyss" class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-div">
                                <h2>3rd year</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>First Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="tyfs" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dtyfs" class="col-md-12">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>Second Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="tyss" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dtyss" class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-div">
                                <h2>4th year</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>First Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="foyfs" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dfoyfs" class="col-md-12">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>Second Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="foyss" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dfoyss" class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-div">
                                <h2>5th year</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>First Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="fiyfs" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dfiyfs" class="col-md-12">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row theader justify-content-between">
                                            <b>Second Semester</b>
                                            <div class="col-md-6 row">
                                                <label class="col-8">Number of subject:</label>
                                                <input type="number" id="fiyss" class="form-control form-control-sm col-md-4">
                                            </div>
                                        </div>
                                        <div id="dfiyss" class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button id="submit" class="btn btn-primary right">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>

    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/dist/js/validation.js"></script>
    <script src="assets/dist/js/pages/curriculum.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/pages/adminlte.min.js"></script>
</body>

</html>