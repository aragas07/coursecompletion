<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/dist/css/registration.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">

</head>

<body>
  <?php
    include("database/DBConnection.php");
    global $conn;
  ?>
    <div class="register" style="height: 100vh; margin: 0">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt="" />
                <h3>Welcome to</h3>
                <p>Davao Oriental State University (DOrSU) <br>Course Completion Web App Analyzer</p>
                <a href="login.php"><input type="submit" name="" value="Login" /></a><br />
            </div>
            <div class="col-md-9 register-right">

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Register Here!</h3>
                        <form class="needs-validation" id="forms" novalidate>
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="register" class="form-control" required placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="fname" class="form-control" required placeholder="First name">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" required placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" required placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="lname" class="form-control" required placeholder="Last name">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="contact" class="form-control" required placeholder="Contact">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <select name="course" class="form-control">
                                        <?php
                                          $getCourse = $conn->query("SELECT * FROM course");
                                          while($row = $getCourse->fetch_assoc()){
                                            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btnRegister" id="register" value="Confirm" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script>
    $(document).ready(function() {
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function(form) {form.addEventListener('submit', function(event) {
                    event.preventDefault();
                if (!form.checkValidity()) {
                    event.stopPropagation();
                    toastr.error("Fill up correctly.");
                }else{
                $.ajax({
                    url: 'database/DBManipulation.php',
                    type: 'post',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        if (result.trim() === "success") {
                            toastr.success("You are successfully registered");
                            setTimeout(
                                function() {
                                    window.location = 'login.php';
                                }, 3000);
                        } else {
                            toastr.error("Fill up correctly.");
                        }
                    }
                })
                }
                form.classList.add('was-validated')
            }, false)
        })
    })
    </script>
</body>

</html>