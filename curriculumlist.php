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
        <input type="hidden" id="course" value="<?php echo $_GET['course']?>">
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <div class="main-container">
                <div class="container-fluid">
                    <div class="card direct-chat direct-chat-primary">
                        <div class="card-header">
                            <h5 class="card-title">Curriculum number <?php echo $_GET['curnum']?></h5>
                        </div>
                        <div class="card-body" style="overflow-x: auto" id="cont">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/pages/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/dist/js/demo.js"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url:'containers/query.php',
                type: 'post',
                data: {getsubject: $("#course").val(), number: <?php echo $_GET['curnum']?>, studentid: ''},
                success: function(result){
                    $("#cont").html(result);
                }
            })
        })
    </script>

</body>

</html>