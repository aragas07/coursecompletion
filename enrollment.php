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
    <style>
        .swal2-title{
            font-size: 1.3em!important;
        }

        .swal2-popup{
            width: 20em!important;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <?php 
            include("database/DBConnection.php");
            global $conn;
            include("containers/sidebar.php");
        ?>
        <input type="hidden" id="page" value="5">
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            </section>
            <div class="main-container">
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header">
                        <div class="card-title">
                            <input type="text" value="<?php echo $_GET['id']?>" class="form-control" placeholder="Search" id="search">
                        </div>
                        <div class="card-tools">
                            <button id="edit-info-btn" class="btn btn-default">Edit Info</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="stud-info">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img id="pro-image" src="assets/dist/img/profile.png" class="col-md-11"
                                        style="margin-bottom: 15px;">
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group row">
                                        <label class="col-sm-12 fol-form-label">ID :
                                            <input type="text" disabled class="form-control">
                                        </label>
                                        <label class="col-sm-12 fol-form-label">First name :
                                            <input type="text" disabled class="form-control">
                                        </label>
                                        <label class="col-sm-12 fol-form-label">Middle name :
                                            <input type="text" disabled class="form-control">
                                        </label>
                                        <label class="col-sm-12 fol-form-label">Last name :
                                            <input type="text" disabled class="form-control">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 fol-form-label">Birth date :</label>
                                <div class="col-sm-4">
                                    <input disabled type="text" class="form-control">
                                </div>
                                <label class="col-sm-2 fol-form-label">Sex :</label>
                                <div class="col-sm-4">
                                    <input disabled type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 fol-form-label">Address :</label>
                                <div class="col-sm-10">
                                    <input disabled type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 fol-form-label">Email :</label>
                                <div class="col-sm-10">
                                    <input disabled type="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <h2 id="enrolled"></h2>
                        <div id="cur-card" hidden class="card collapsed-card">
                            <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                                <div class="card-title form-group row col-md-11">
                                    <label class="fol-form-label">Institue :</label>
                                    <div class="col-sm-2">
                                        <select id="institute" class="form-control">
                                            <?php 
                                                $getCourse = $conn->query("SELECT * FROM institute ORDER BY name ASC");
                                                while($row = $getCourse->fetch_assoc()){
                                                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <label class="fol-form-label">Course :</label>
                                    <div class="col-sm-5">
                                        <select id="course" class="form-control">
                                            <?php 
                                                        $getCourse = $conn->query("SELECT * FROM course WHERE institute_id = 14");
                                                        while($row = $getCourse->fetch_assoc()){
                                                            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                                        }
                                                    ?>
                                        </select>
                                    </div>
                                    <label class="fol-form-label">Curriculum :</label>
                                    <div class="col-sm-2">
                                        <select id="cur" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <!-- card tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-angle-down"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body" style="display: none;">
                                <div id="world-map" style="width: 100%; position: relative;">
                                    <div id="cur-div"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="submit" type="button">Admit</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        

        <!-- /.content -->
    </div>


    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <!-- /.control-sidebar -->

    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script>
    $(document).ready(function(e) {
        $("#institute").change(function(){
            displayCourse($(this).val());
        })

        function displayCourse(id){
            $.ajax({
                url: 'database/DBManipulation.php',
                type: 'post',
                data: {getCourse: id},
                success: function(result){
                    $("#course").html(result);
                }
            })
        }
        $("#submit").click(function(){
            Swal.fire({
                title: 'Confirm admission',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'containers/query.php',
                        type: 'post',
                        data: {
                            enrolled: $("#course").val(),
                            cur: $("#cur").val(),
                            studentId: $("#stud-id").val()
                        },
                        success: function(result) {
                            if (result.trim() == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Student succesfully admitted',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $("#adding").modal('hide');
                                setTimeout(() => {
                                    location.href = 'index.php';
                                }, 1500);
                            } else {
                                toastr.error('Sorry!');
                            }
                        }
                    })
                }
            })
        })

        $("#edit-info-btn").click(function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "Update the information of the student?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update the information!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#info-form").submit();
                }
            })
        })

        $("#cur").change(function(){
            loadSubject($(this).val());
        })

        $("#course").change(function() {
            loaddata($(this).val(),1);
        })

        $("#search").keyup(function() {
            load($(this).val());
        })

        load($("#search").val());

        function loadSubject(id){
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {getsubject: $("#course").val(), number: id, studentid: ''},
                success: function(result){
                    $("#cur-div").html(result);
                }
            })
        }

        function loaddata(text,cur) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    getAllcurrOfCourse: text
                },
                success: function(result) {
                    $("#cur").empty().append(result);
                    $("#cur").val(parseInt(cur));
                    loadSubject($("#cur").val());
                }
            })
        }

        function load(text) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    searchstudent: text
                },
                success: function(result) {
                    var split = result.split("||");
                    $("#stud-info").html(split[1]);
                    if($("#stud-id").val().trim() != ''){
                        $("#cur-card").attr("hidden", false);
                    }else{
                        $("#cur-card").attr("hidden", true);
                        $("#enrolled").text("");
                    }
                    if(split[2] != ''){
                        $("#submit").prop('hidden',true);
                        $("#enrolled").text("Admitted at");
                        displayCourse(split[3]);
                        $("#institute").val(split[3]);
                        loaddata(split[2],split[0]);
                    }else{
                        loaddata($("#course").val(),1);
                    }
                    $("#info-form").on('submit',function(e){
                        e.preventDefault();
                        $.ajax({
                            url: 'database/DBManipulation.php',
                            method: 'POST',
                            data: new FormData(this),
                            contentType:false,
                            cache: false,
                            processData: false,
                            success: function(result){
                                if(result.trim() == 'success'){
                                    toastr.success('Information successfully updated!');
                                }else{
                                    toastr.error('Sorry!');
                                }
                                alert(result);
                                load($("#search").val());
                            }
                        })
                    });
                }
            })
        }
    })
    </script>

    <script src="assets/dist/js/validation.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/pages/adminlte.min.js"></script>

</body>

</html>