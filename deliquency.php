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
        <input type="hidden" id="page" value="8">
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            </section>

            <div class="main-container">
                <div class="container-fluid">
                    <div class="card direct-chat direct-chat-primary">
                        <div class="card-body">
                            <h2>SCHOLASTIC DELINQUENCY</h2>
                             1. The faculty of each academic unit shall approve suitable and effective provisions governing
                                undergraduate delinquent students subjects to the following minimum standards:
                            <ul>
                                <li><p>Warning- A student who obtains final grade below "3.0" in 25 percent to 49 percent of the
                                    total number of academic units in which he/she is registered shall carry 75% of the regular load. 
                                </p></li>
                                <li><p>Probation - A student who obtains final grade below "3.0" in at least 50 percent to 75 percent of the
                                    total number of academic units in which he/she is registered shall carry 50% of the regular load. </p></li>
                                <li><p>Debarment - A student who obtains final grade below "3.0" in at least 76 percent of the
                                    total number of academic units in which he/she recieves final grades shall be barred for readmission to the 
                                College; but may apply for readmission after 1 year; provided that this shall not apply to students who recieves final grades 
                            in less than 9 academic units. </p></li>
                            </ul>
                            <p>2. Names should be submitted to the Guidance Counseling in Testing Center (GCTC) for counseling purposes. </p>
                            <p>3. The scholarship rules regarding the permanent disqualification do not apply to the cases where, on the recommendation of the 
                            instructor concerned, the faculty certifies the grades of 5.0 were due to the students unauthorized dropping of the subject and not 
                            to poor scholarship. However, if the unauthorized withdrawal takes place after the midterm and the student's class stranding is poor, 
                            his grades of 5.0 shall be counted against him for the purpose of the scholarship rule.</p>
                            <p>4. A grade of INC is not to be included in the computation, when it is replaced by a final grade; the latter is to be included in the 
                            grades during the semester when the removal is made. </p>
                            <p>5. No readmission of dismissed/disqualified students shall be considered by the Director for Instruction without the approval of the 
                                College Council.</p>


                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.content -->
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