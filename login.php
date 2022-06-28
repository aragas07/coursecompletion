<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/credit/dorsu.ico">
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/dist/css/alt/login.css">
  <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
  <?php
    error_reporting(0);
    if($_SESSION['auth']){
      header("location:index.php");
    }
  ?>
</head>
<body>
<div class="container">
        <div class="card card-login mx-auto text-center bg-light">
            <div class="card-header mx-auto bg-light">
                <span> <img src="assets/dist/img/dorsu.png" class="w-25" alt="Logo"> </span><br/>
                            <span class="mt-5">Davao Oriental State University</span>
    
            </div>
            <div class="card-body">
                <form class="needs-validation" id="forms" novalidate>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" id="username" class="form-control" name="login" placeholder="Username" autofocus required>
                    </div>
    
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" id="password" class="form-control" name="login" placeholder="Password" required>
                    </div>
                    <input type="text" hidden required>
                    <input type="submit" name="btn"  id="login" value="Log In" class="btn btn-outline-primary float-left login_btn">
    
    
                </form><br>
                <div class="form-group">
                    <i style="float:left; font-size: 14px; float: right">Don't have an account? <a href="registration.php">Register</a> Here</i>
                </div>
            </div>
    </div>
</div>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/dist/js/validation.js"></script>
    <script>
        $(function(){
            $("#login").click(function(){
                $.ajax({
                    url: 'database/DBManipulation.php',
                    type: 'post',
                    data: {
                        login: $("#username").val(),
                        password: $("#password").val()
                    }, success: function(result){
                        if(result.trim() === "success"){
                            toastr.success("You are successfully logged in");
                            setTimeout(
                            function() {
                                window.location = 'index.php';
                            }, 1000);
                        }else{
                            toastr.error(result);
                        }
                    }
                })
            })
        })
    </script>
    
</body>
</html>

