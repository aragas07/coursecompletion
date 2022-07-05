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
        <input type="hidden" id="page" value="4">
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            </section>

            <div class="main-container">
                <div class="container-fluid">
                    <div class="card direct-chat direct-chat-primary">
                        <div class="card-header">
                            <div class="card-title">
                                <input type="text" name="" placeholder="Search" id="search" class="form-control">
                            </div>
                            <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#irregular" id="irreg" data-toggle="tab">Irregular</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#allstudent" id="reg" data-toggle="tab">All student</a>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="tab-pane active" style="position: relative" id="allstudent">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First name</th>
                                                <th>Middle name</th>
                                                <th>Last name</th>
                                                <th>Birth</th>
                                                <th>Sex</th>
                                                <th>Address</th>
                                                <th>Email</th>
                                                <th>Year level</th>
                                            </tr>
                                        </thead>
                                        <tbody id="s-table">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="irregular" style="position: relative">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First name</th>
                                                <th>Middle name</th>
                                                <th>Last name</th>
                                                <th>Birth</th>
                                                <th>Sex</th>
                                                <th>Address</th>
                                                <th>Email</th>
                                                <th>Year level</th>
                                                <th>Deliquency</th>
                                            </tr>
                                        </thead>
                                        <tbody id="irreg-table">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#choices">Add student</button>
                            <ul id="paging" class="pagination pagination-sm m-0 float-right"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.content -->
        </div>

        <div class="modal fade" id="choices">
            <div class="modal-dialog modal-sm">
                <div class="modal-content p-3">
                    <div class="form-group">
                        <button class="btn btn-outline-secondary col-12" data-toggle="modal" data-target="#adding">New
                            Student</button>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-secondary col-12" data-toggle="modal"
                            data-target="#upl-csv">Upload CSV</button>
                    </div>
                    <button class="btn btn-outline-danger col-12" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="adding">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Student</h4>
                        <button type="button" class="close" id="add-modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" id="forms" novalidate>
                            <div class="row">
                                <div class="col-sm-4">
                                    <img id="pro-image" src="assets/dist/img/profile.png" class="col-md-11"
                                        style="margin-bottom: 5px;">
                                    <button id="custom-btn" class="btn btn-primary col-md-11" type="button">CHOOSE
                                        IMAGE</button>
                                    <input type="file" name="file" class="f-input"
                                        accept="image/x-png,image/gif,image/jpeg" hidden id="default-btn">
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group row">
                                        <label class="col-sm-12 fol-form-label">ID :
                                            <input type="text" name="studId" required
                                                class="form-control form-control-sm f-input">
                                        </label>
                                        <label class="col-sm-12 fol-form-label">First name :
                                            <input type="text" name="fname" required
                                                class="form-control form-control-sm f-input">
                                        </label>
                                        <label class="col-sm-12 fol-form-label">Middle name :
                                            <input type="text" name="mname" required
                                                class="form-control form-control-sm f-input">
                                        </label>
                                        <label class="col-sm-12 fol-form-label">Last name :
                                            <input type="text" name="lname" required
                                                class="form-control form-control-sm f-input">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 fol-form-label">Birth date :</label>
                                <div class="col-sm-4">
                                    <input name="bday" type="date" required
                                        class="form-control form-control-sm f-input">
                                </div>
                                <label class="col-sm-2 fol-form-label">Sex :</label>
                                <div class="col-sm-4">
                                    <select name="gender" class="form-control form-control-sm">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 fol-form-label">Address :</label>
                                <div class="col-sm-10">
                                    <input name="address" type="text" required
                                        class="form-control form-control-sm f-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 fol-form-label">Email :</label>
                                <div class="col-sm-10">
                                    <input name="email" type="email" required
                                        class="form-control form-control-sm f-input">
                                </div>
                            </div>
                            <input type="text" hidden required>
                            <div class="col-12">
                                <button class="btn btn-primary" id="submit" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="enrol">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enrolled At</h4>
                        <button type="button" class="close" id="add-modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h1 id="course-title"></h1>
                        <h2 id="course-cur"></h2>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button id="vgrade" class="btn btn-default">View grades</button>
                        <button id="change-course" class="btn btn-primary">View Details</button>
                    </div>
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
                                <h1>File format for the column header</h1>
                                <h3>Id, First name, Middle name, Last name, Birth date, Sex, Address, Email</h3>
                            </div>
                            <input type="file" accept=".csv" class="form-control" name="studentfile">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                            <button id="change-course" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#forms").on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'database/DBManipulation.php',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    $(".f-input").each(function() {
                        $(this).val(null);
                        $("#pro-image").attr("src", "assets/dist/img/profile.png");
                    })
                    toastr.success("Success to insert");
                    load($("#search").val(), 1);
                    paging($("#search").val(), 1);
                    $("#adding").modal("hide");
                }
            })
        })

        $("#upcsv").submit(function(e) {
            e.preventDefault();
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
                    if (result.success) {
                        toastr.success(result.response);
                        setTimeout(function() {
                            location.reload();
                        }, 1300);
                    } else {
                        toastr.error(result.response);
                    }
                }
            })
        })

        $("#irreg").click(function(){
            type = 'irreg';
            paging($("#search").val(), 1);
        })

        $("#reg").click(function(){
            type = 'student';
            paging($("#search").val(), 1);
        })

        var b = true,
            studId = 0, type="student";
        $("#search").keyup(function() {
            load($(this).val(), 1);
            loadirreg($(this).val(), 1);
            paging($(this).val(), 1);
        })
        paging('', 1);
        load('', 1);
        loadirreg('', 1);

        function paging(search, id) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    subjectpaging: id,
                    searching: search,
                    type: type
                },
                success: function(result) {
                    $("#paging").html(result);
                    $(".page-link").click(function() {
                        var chunk = $(this).attr('class').split(" ");
                        paging($("#search").val(), chunk[1]);
                        load($("#search").val(), chunk[1]);
                    })
                }
            })
        }

        function load(text, page) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    disStudent: text,
                    page: page
                },
                success: function(result) {
                    $("#s-table").html(result);
                    $(".data").click(function() {
                        $("#stud-id").val($(this).attr('id'));
                    })
                    $(".enrolled").click(function() {
                        $split = $(this).attr('id').split('||');
                        $("#vgrade").click(function() {
                            window.location.href = 'grades.php?id=' + $split[0];
                        })
                        $("#change-course").click(function() {
                            window.location.href = "enrollment.php?id=" + $split[0];
                        })
                        $("#course-cur").text("Curriculum number: " + $split[2]);
                        $.ajax({
                            url: 'containers/query.php',
                            type: 'post',
                            data: {
                                getCourseName: $split[1]
                            },
                            success: function(result) {
                                $("#course-title").text(result);
                            }
                        })
                    })
                }
            })
        }
        
        function loadirreg(text, page) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    disStudentirreg: text,
                    page: page
                },
                success: function(result) {
                    $("#irreg-table").html(result);
                    $(".data").click(function() {
                        $("#stud-id").val($(this).attr('id'));
                    })
                    $(".enrolled").click(function() {
                        $split = $(this).attr('id').split('||');
                        $("#vgrade").click(function() {
                            window.location.href = 'grades.php?id=' + $split[0];
                        })
                        $("#change-course").click(function() {
                            window.location.href = "enrollment.php?id=" + $split[0];
                        })
                        $("#course-cur").text("Curriculum number: " + $split[2]);
                        $.ajax({
                            url: 'containers/query.php',
                            type: 'post',
                            data: {
                                getCourseName: $split[1]
                            },
                            success: function(result) {
                                $("#course-title").text(result);
                            }
                        })
                    })
                }
            })
        }
    })
    const custom = document.querySelector("#custom-btn"),
        defaultbtn = document.querySelector("#default-btn"),
        img = document.querySelector("#pro-image");
    custom.addEventListener("click", function() {
        defaultbtn.click();
    });

    defaultbtn.addEventListener("change", function() {
        const file = defaultbtn.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const result = reader.result;
                img.src = result;
            }
            reader.readAsDataURL(file);
        }
    });
    </script>

    <script src="assets/dist/js/validation.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/pages/adminlte.min.js"></script>

</body>

</html>