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
        <input type="hidden" id="page" value="3">
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
                                <label><input type="text" placeholder="Search" class="form-control" id="search"></label>
                            </div>
                            <div class="card-tools">
                                <button class="btn btn-primary" data-toggle="modal" id="adding-modal" data-target="#choices">Add Subject</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-sm-3">Course no.</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody id="s-list">
                                </tbody>
                            </table>
                            <div style="margin-top: 10px">
                                <ul id="paging" class="pagination pagination-sm m-0 float-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="choices">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content p-3">
                        <div class="form-group">
                            <button class="btn btn-outline-secondary col-12" data-toggle="modal" data-target="#adding">Add Subject</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-outline-secondary col-12" data-toggle="modal" data-target="#upl-csv">Upload CSV</button>
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
                        <form action="database/DBManipulation.php" method="post">
                            <div class="modal-body">
                                <div class="text-center">
                                    <h1>File format for the column header</h1>
                                    <h3>Course no., Description, Unit</h3>
                                </div>
                                <input type="file" class="form-control" name="subject-file">
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button data-dismiss="modal" class="btn btn-default">Cancel</button>
                                <button id="change-course" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="adding">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Subject</h4>
                            <button type="button" class="close" id="add-modal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" id="forms" novalidate>
                                <div class="form-group row">
                                    <label class="col-sm-3 fol-form-label" for="courseno">Course no.</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="courseno" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 fol-form-label" for="description">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="description" required class="form-control s-cont form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 fol-form-label" for="unit">Unit</label>
                                    <div class="col-sm-9">
                                        <input type="number" id="unit" required class="form-control s-cont form-control-sm">
                                    </div>
                                </div>
                                <input type="text" hidden required>
                                <button class="btn btn-primary right" id="add-sub">Submit</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->

    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/dist/js/validation.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/pages/adminlte.min.js"></script>

    <script>
        $(function(){
            $("#add-sub").click(function(){
                var b = true;
                $(".s-cont").each(function(){
                    $(this).val($(this).val().trim());
                    if($(this).val().length == 0) b = false;
                })
                if(b){
                    $.ajax({
                        url: 'database/DBManipulation.php',
                        type: 'post',
                        data: {
                            addSub: $("#courseno").val(),
                            description: $("#description").val(),
                            unit: $("#unit").val()
                        }, success: function(result){
                            if(result.trim() == 'true'){
                                toastr.success("Success");
                            }else{toastr.error("Error!");}
                            $("#adding").modal('hide');
                            showTable('',1);
                        }
                        
                    })
                }
                $(".form-control").each(function(){
                    $(this).val("");
                })
            })

            $("#search").keyup(function(){
                showTable($(this).val(),1);
                paging($(this).val(),1);
            })
            paging($("#search").val(),1);
            function paging(search,id){
                $.ajax({
                    url: 'containers/query.php',
                    type: 'post',
                    data: {subjectpaging: id,searching: search, type: "subject"},
                    success: function(result){
                        $("#paging").html(result);
                        $(".page-link").click(function(){
                            var chunk = $(this).attr('class').split(" ");
                            paging($("#search").val(),chunk[1]);
                            showTable($("#search").val(),chunk[1]);
                        })
                    }
                })
            }
            function showTable(text,page){
                $.ajax({
                    url: 'containers/query.php',
                    type: 'post',
                    data: {showsubject: text, page: page},
                    success: function(result){
                        $("#s-list").html(result);
                    }
                })
            }
            showTable('',1);
        })
    </script>

</body>

</html>