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
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <?php 
                include("database/DBConnection.php");
                global $conn;
                include("containers/sidebar.php");
            ?>
            <input type="hidden" id="page" value="2">
            <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <div class="main-container">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#adding">Add</button>
                            </div>
                        </div>

                        <div class="card-body" id="index-body">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="adding">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Course</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" id="forms" novalidate>
                                <div class="form-group row">
                                    <label for="institute" class="col-md-12">Institute</label>
                                    <div class="col-sm-12">
                                        <select name="" id="institute" class="custom-select">
                                            <?php 
                                                $getIns = $conn->query("SELECT * FROM institute");
                                                while($rows = $getIns->fetch_assoc()){
                                                    echo '<option value="'.$rows['id'].'">'.$rows['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="course" class="col-md-12">Course name</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="studid" id="course" required
                                            class="form-control form-control-sm">
                                    </div>
                                    <input type="text" hidden required>
                                </div>
                                <button class="btn btn-primary col-12" id="submit" type="submit">Submit</button>
                            </form>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/dist/js/pages/adminlte.min.js"></script>


    <script>
    $(document).ready(function() {
        var location = 'containers/query.php';

        function displaycourse() {
            $.ajax({
                url: location,
                type: 'post',
                data: {
                    displaycourse: 'viewing'
                },
                success: function(result) {
                    $("#index-body").html(result);
                }
            })
        }
        displaycourse();
        $("#submit").click(function() {
            if ($("#course").val().length > 0) {
                $course = $("#course").val();
                $ins = $("#institute").val();
                $.ajax({
                    url: location,
                    type: 'post',
                    data: {
                        course: $course,
                        ins: $ins
                    },
                    success: function(result) {
                        if (result == 'error') toastr.error(
                            'Sorry you are not able to added data')
                        else if (result == 'exist') toastr.info(
                            'Sorry the data is existed')
                        else {
                            toastr.success('Successfully to added a course');
                            $("#adding").modal('hide');
                            displaycourse();
                        }
                    }
                })
            }
        })
        var forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated')
                }, false)
            })

    })
    </script>

</body>

</html>