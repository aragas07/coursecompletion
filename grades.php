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
        #loading{
            position: fixed; 
            top: 0; 
            left: 0; 
            height: 100vh; 
            width: 100vw; 
            background-color: #5a5a5a49;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    <!-- CHANGES -->
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <!-- END OF CHANGES -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php 
            include("database/DBConnection.php");
            global $conn;
            include("containers/sidebar.php");
        ?>
        <input type="hidden" id="page" value="7">
        <script src="assets/dist/js/active.js"></script>
        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <input id="0" class="comp-grades form-control" type="hidden" />
            <div class="main-container">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#curriculum" data-toggle="tab">Curriculum</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#grades" data-toggle="tab">Grades</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="col-md-12 row" id="info">
                                    <img id="pro-image" src="assets/dist/img/profile.png" class="col-md-2"
                                        style="margin-bottom: 15px">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Student ID</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="search" value="<?php echo $_GET['id']?>" placeholder="Search" class="form-control form-control-sm">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Birth date</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="birth" class="form-control form-control-sm" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="fname" class="form-control form-control-sm" disabled>
                                            </div>
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="email" class="form-control form-control-sm" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Sex</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="gender" class="form-control form-control-sm" disabled>
                                            </div>
                                            <label class="col-sm-2 col-form-label">Course</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="course" class="form-control form-control-sm" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chart tab-pane" id="curriculum" style="position: relative">
                                    <div id="cur-panel" class="col-md-12">
                                        <div class="table-div">
                                            <i>1st year</i>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>First Semester</th>
                                                        <th>Second Semester</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-div">
                                            <i>2nd year</i>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>First Semester</th>
                                                        <th>Second Semester</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-div">
                                            <i>3rd year</i>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>First Semester</th>
                                                        <th>Second Semester</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-div">
                                            <i>4th year</i>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>First Semester</th>
                                                        <th>Second Semester</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                        <th>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px">course no.</th>
                                                                        <th>Description</th>
                                                                        <th style="width:75px">Unit</th>
                                                                        <th style="width:150px">Prerequisites</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="chart tab-pane active row" id="grades" style="position: relative">
                                    <div class="col-md-12" style="margin-bottom: 20px">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Year</td>
                                                    <td>Sem</td>
                                                    <td>Subject
                                                        <input type="number" id="sub-num" placeholder="Input number of subject (4)" class="form-control right form-control-sm col-md-4">
                                                    </td>
                                                    <td>Final grades</td>
                                                </tr>
                                            </thead>
                                            <tbody id="s-subject"></tbody>
                                        </table>
                                        <button id="submit-grades" class="btn btn-primary">Submit</button>
                                    </div>
                                    <div class="row" id="t-subject"></div>
                                    <button hidden class="btn btn-primary" id="submit-comp">Submit compliance</button>
                                    <button id="send-email-btn" class="btn btn-danger btn-rounded mb-4">Send Grades to Email</button>
                                    <input type="text" class="form-control right col-sm-2 form-control-sm" id="r-year" disabled>
                                    <label class="right mr-3">Remaining year's:</label>
        
                                </div>
                                <!-- END OF CHANGES -->
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="loading">
        <i class="fa fa-spinner fa-spin" style="font-size:72px; color: white"></i>
    </div>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/pages/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/dist/js/demo.js"></script>
    <script>
    $(function() {
        var studid = 0;
        $("#search").keyup(function() {
            search($(this).val(), true);
        })

        search($("#search").val(), true);

        function search(text, b) {
            if (text.length > 4) {
                $.ajax({
                    url: 'containers/query.php',
                    type: 'post',
                    data: {
                        show: text
                    },
                    success: function(result) {
                        if (result.trim() != '') {
                            var split = result.split("||");
                            if (b) {
                                $("#pro-image").attr('src',split[2]);
                                $("#fname").val(split[3]);
                                $("#birth").val(split[4]);
                                $("#gender").val(split[5]);
                                $("#email").val(split[6]);
                                $("#course").val(split[7]);
                                //$("#info").html(split[2]);
                                $.ajax({
                                    url: 'containers/query.php',
                                    type: 'post',
                                    data: {
                                        getsubject: split[0],
                                        number: split[1],
                                        studentid: text
                                    },
                                    success: function(result) {
                                        $("#cur-panel").html(result);
                                    }
                                })
                            }
                            loadsubject(split[0], split[1], 4);
                            $("#sub-num").change(function() {
                                loadsubject(split[0], split[1], $(this).val());
                            })
                        } else if (text.length > 8) {
                            toastr.error("Sorry, but this data does not exist.");
                        }
                    }
                })
                update(text);
            }
        }

        $("#submit-grades").click(function() {
            $.ajax({
                url: 'database/DBManipulation.php',
                type: 'post',
                data: {
                    latest: $("#search").val()
                },
                success: function(latest) {
                    var split = latest.split('||'),
                        b = true;
                    $(".input-grades").each(function() {
                        if ($(this).val().trim() == '') b = false;
                    });
                    if (b) {
                        $(".input-grades").each(function() {
                            $.ajax({
                                url: 'database/DBManipulation.php',
                                type: 'post',
                                data: {
                                    inputGrades: $("#search").val(),
                                    grades: $(this).val(),
                                    subject: $(this).attr('id'),
                                    year: split[0],
                                    sem: split[1]
                                },
                                success: function() {}
                            })
                        })
                        toastr.success("Successful!");
                    } else toastr.error("Sorry, but you must fill out the input text area completely.");
                    search($("#search").val(), false);
                }
            })
        })


        function loadsubject(subject, number, loop) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    takenSubject: subject,
                    number: number,
                    loop: loop
                },
                success: function(result) {
                    $("#s-subject").html(result);
                    $(".select-sem").each(function(index){
                        $(this).change(function(){
                            selectsub(subject, number, $(".select-year").eq(index).val(), $(this).val(), $(".subject-cont").eq(index));
                            setInId();
                        })
                    })
                    $(".select-year").each(function(index){
                        $(this).change(function(){
                            selectsub(subject, number, $(this).val(), $(".select-sem").eq(index).val(), $(".subject-cont").eq(index));
                            setInId();
                        })
                    })
                    $(".subject-cont").each(function(index) {
                        selectsub(subject, number, $(".select-year").eq(index).val(), $(".select-sem").eq(index).val(), $(this));
                    });
                    setInId();
                }
            });
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {remaining: subject, number: number, studentid: $("#search").val()},
                success: function(result){
                    $("#r-year").val(result);
                }
            })
        }

        function setInId(){
            setTimeout(() => {
                $(".select-subject").each(function(index){
                    $(".input-grades").eq(index).attr('id',$(this).val());
                    $(this).change(function(){
                        $(".input-grades").eq(index).attr('id',$(this).val());
                    })
                })
            }, 700);
        }

        function selectsub(subject, number, year, sem, sub) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    fetchSubject: subject,
                    number: number,
                    year: year,
                    semester: sem
                },
                success: function(result) {
                    sub.html(result);
                }
            })
        }


        function update(id) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    displayTaken: id
                },
                success: function(result) {
                    $("#t-subject").html(result);
                    let b = true;
                    $(".edit-grades-btn").click(function(){
                        $(this).html('Save').attr('class','btn btn-primary mb-3 edit-grades-btn');
                        let c = $(this).attr('id')+b;
                        let btnid = $(this).attr('id');
                        if(c == $(this).attr('id')+true){
                            $("."+$(this).attr('id')).each(function(){
                                const grade = $(this).text();
                                $(this).empty();
                                $(this).append('<input type="text" id="'+$(this).attr('id')+'" style="width: 100px" class="inp'+btnid+' form-control form-control-sm" value="'+grade+'">');
                            })
                        }else{
                            $(".inp"+$(this).attr('id')).each(function(){
                                $.ajax({
                                    url: 'database/DBManipulation.php',
                                    type: 'post',
                                    data: {
                                        inputComp: $(this).val(),
                                        idsubject: $(this).attr('id')
                                    },
                                    success: function(result) {
                                    }
                                })
                            })
                            toastr.success("Grades have been successfully saved.");
                            update($("#search").val());
                        }
                        b = false;
                    });
                    for(var i = 0; i < ($(".warning").length - 1) ;i++){
                        $(".warning").eq(i).attr('hidden', true);
                    }
                }
            })
        }

        function showGrades(year) {
            $.ajax({
                url: 'containers/query.php',
                type: 'post',
                data: {
                    studid: studid[0],
                    schyear: year,
                    courseid: studid[1]
                },
                success: function(result) {
                    $("#g-table").html(result);
                }
            })
        }

        // CHANGES
        $('#send-email-btn').click(() => {
            const email = $("#email").val().trim()
            const emailFilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
            const data = $('#emailGrades').html()
            $.ajax({
                url: 'containers/mail.php',
                type: 'post',
                data:{data: data, email: email},
                success: function(data){
                    alert(data)
                }
            })
            // if (!emailFilter.test(email)) {
            //     alert('Please provide a valid email address');
            // } else {
            //     const data = $('#emailGrades').html()
            //     Email.send({
            //         SecureToken: "8f156ef2-f424-40bf-8154-893f496b9a1c",
            //         To : email,
            //         setFrom : new helper.Email("2018-0809@doscst.edu.ph","example"),
            //         Subject : "Grades",
            //         Body : data
            //     }).then(message => {
            //         alert(message)
            //     });
            // }
        })
        // END OF CHANGES
    })
    </script>

</body>

</html>