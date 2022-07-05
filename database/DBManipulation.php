<?php
    include("DBConnection.php");
    global $conn;
    session_start();
    if(isset($_POST['addSub'])){
        $success = 'false';
        $course = $_POST['addSub'];
        $description = $_POST['description'];
        $unit = $_POST['unit'];
        $existed = $conn->query("SELECT * FROM subject WHERE course_num = '$course' AND subject_description = '$description'");
        if($existed->num_rows == 0){
            if(mysqli_query($conn,"INSERT INTO subject(course_num, subject_description, unit) VALUES('$course','$description','$unit')")){
                $success = 'true';
            }
        }else{$success = 'true';}
        echo $success;
    }else if(isset($_POST['login'])){
        $username = $_POST['login'];
        $pass = $_POST['password'];
        $login = $conn->query("SELECT * FROM admin INNER JOIN course ON admin.course_id = course.id WHERE username = '$username' AND password = '$pass'");
        if($login->num_rows > 0){
            echo 'success';
            $_SESSION['auth'] = true;
            while($row = $login->fetch_assoc()){
                $_SESSION['courseId'] = $row['course_id'];
            }
        }else{
            echo 'Sorry you are not able to login';
        }
//dfdf
    }else if(isset($_POST['register'])){
        if(mysqli_query($conn,"INSERT INTO admin(fname,lname,course_id,username,password,contact) VALUES('".$_POST['fname']."','".$_POST['lname']."',".$_POST['course'].",'".$_POST['register']."','".$_POST['password']."','".$_POST['contact']."')")){
            echo 'success';
        }else{
            echo 'Sorry you are not able to register';
        }
    }else if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('location:../');
    }else if(isset($_POST['latest'])){
        $student = $_POST['latest'];
        $getYear = $conn->query("SELECT * FROM takes WHERE student_id = '$student' ORDER BY year DESC LIMIT 1");
        if($getYear->num_rows > 0){
            while($year = $getYear->fetch_assoc()){
                $yr = $year['year'];
                $getSem = $conn->query("SELECT * FROM takes WHERE student_id = '$student' AND year = $yr ORDER BY sem DESC LIMIT 1");
                while($sem = $getSem->fetch_assoc()){
                    $ts = $sem['sem'];
                }
            }
            if($ts == 2){$yr++; $ts = 1;}
            else{$ts++;}
        }else{
            $yr = 1;
            $ts = 1;
        }
        echo $yr.'||'.$ts;
    }else if(isset($_POST['inputGrades'])){
        $student = $_POST['inputGrades'];
        $subject = $_POST['subject'];
        $grades = $_POST['grades'];
        $yr = $_POST['year'];
        $ts = $_POST['sem'];
        if(mysqli_query($conn,"INSERT INTO takes(student_id,subject_id,grades,year,sem) VALUES('$student',$subject,'$grades',$yr,$ts)")){
            echo 'ssuccess';
        }else{echo 'error';}
    }else if(isset($_POST['inputComp'])){
        $comply = $_POST['inputComp'];
        $id = $_POST['idsubject'];
        if(mysqli_query($conn,"UPDATE takes SET grades = $comply WHERE id = $id")){
            $getSubject = $conn->query("SELECT * FROM takes INNER JOIN subject ON subject_id = subject.id WHERE takes.id = $id");
            while($row = $getSubject->fetch_assoc()){
                echo $row['subject_description'];
            }
        }
    }else if(isset($_FILES['file']['name'])){
       $filename = $_FILES['file']['name'];
       $location = "../upload/".$filename;
       $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
       $imageFileType = strtolower($imageFileType);
       $valid_extensions = array("jpg","jpeg","png");
       $response = 0;
       echo $filename;
       if(in_array(strtolower($imageFileType), $valid_extensions)) {
          if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
            if(mysqli_query($conn,"INSERT INTO student (id,profile,Fname,mname,lname,bday,gender,year,email,status,address) VALUES('".$_POST['studId']."','$filename','".$_POST['fname']."','".$_POST['mname']."','".$_POST['lname']."','".$_POST['bday']."','".$_POST['gender']."',1,'".$_POST['email']."','Regular','".$_POST['address']."')") == true){
               echo 'success';
            }else{echo "error";}
          }
       }else{
            if(mysqli_query($conn,"INSERT INTO student (id,profile,Fname,mname,lname,bday,gender,year,email,status,address) VALUES('".$_POST['studId']."','','".$_POST['fname']."','".$_POST['mname']."','".$_POST['lname']."','".$_POST['bday']."','".$_POST['gender']."',1,'".$_POST['email']."','Regular','".$_POST['address']."')") == true){
            echo 'success';
            }else{echo "error";}
        }
    
    }else if(isset($_POST['studid'])){
        $fname = $_POST['fname'];
        $id = $_POST['studid'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $bday = $_POST['bday'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        if(mysqli_query($conn,"UPDATE student SET fname='$fname', mname='$mname',lname='$lname',bday='$bday',gender='$gender',email='$email',address='$address' WHERE id = '$id'")){
            echo 'success';
        }else{
            echo 'error';
        }
    }else if(isset($_FILES['studentfile']['name'])){
        $csvFile = fopen($_FILES['studentfile']['tmp_name'], 'r');
        $bool = false;
        $response = '';
        while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE){
            $id = $getData[0];
            $fname = $getData[1];
            $mname = $getData[2];
            $lname = $getData[3];
            $bday = $getData[4];
            $sex = $getData[5];
            $address = $getData[6];
            $email = $getData[7];
            if(strtolower($id) == 'id' && strtolower($fname) == 'first name' && strtolower($mname) == 'middle name' && strtolower($lname) == 'last name' && 
            strtolower($bday) == 'birth date' && strtolower($sex) == 'sex' && strtolower($address) == 'address' && strtolower($email) == 'email'){
                $bool = true;
            }else if($bool){
                $query = "SELECT id FROM student WHERE email = '$email' AND id = '$id'";
                $check = mysqli_query($conn, $query);
                if ($check->num_rows == 0){
                    mysqli_query($conn, "INSERT INTO student(id,fname,mname,lname,bday,gender,address,email) VALUES('$id','$fname','$mname','$lname','$bday','$sex','$address','$email')");
                }
                $response = 'The file has been uploaded.';
            }else{
                $response = "The file format is incorrect.";
            }
        }
        echo json_encode(['success'=>$bool,'response'=>$response]);
    }else if(isset($_FILES['subjectfile']['name'])){
        $csvFile = fopen($_FILES['subjectfile']['tmp_name'], 'r');
        $bool = false;
        $response = '';
        while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE){
            $course = $getData[0];
            $description = $getData[1];
            $unit = $getData[2];
            if(strtolower($course) == 'course no.' && strtolower($description) == 'description' && strtolower($unit) == 'unit' ){
                $bool = true;
            }else if($bool){
                $query = "SELECT id FROM subject WHERE course_num = '$course' AND subject_description = '$description'";
                $check = mysqli_query($conn, $query);
                if ($check->num_rows == 0){
                    mysqli_query($conn, "INSERT INTO subject(course_num, subject_description, unit) VALUES('$course','$description','$unit')");
                }
                $response = 'The file has been uploaded.';
            }else{
                $response = "The file format is incorrect.";
            }
        }
        echo json_encode(['success'=>$bool,'response'=>$response]);
    }else if(isset($_FILES['gradesfile']['name'])){
        $csvFile = fopen($_FILES['gradesfile']['tmp_name'], 'r');
        $bool = false;
        $response = '';
        while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE){
            $ID = $getData[0];
            $course = $getData[1];
            $description = $getData[2];
            $year = $getData[3];
            $sem = $getData[4];
            $grade = $getData[5];
            if(strtolower($year) == 'year' && strtolower($sem) == 'sem' && strtolower($course) == 'course no.' && strtolower($description) == 'description' && strtolower($grade) == 'grades' && strtolower($ID) == 'student id'){
                $bool = true;
            }else if($bool){
                $subject = '';
                $getSubject = $conn->query("SELECT * FROM subject WHERE course_num LIKE '%$course%' AND subject_description LIKE '%$description%'");
                while($sub = $getSubject->fetch_assoc()){
                    $subject = $sub['id'];
                }
                if($getSubject->num_rows != 0){
                    if(mysqli_query($conn,"INSERT INTO takes(student_id,subject_id,grades,year,sem) VALUES('$ID',$subject,'$grade',$year,$sem)")){
                        $response = 'The file has been uploaded.';
                    }else{
                        $response = "The file format is incorrect.";
                    }
                }
            }else{
                $response = "The file format is incorrect.";
            }
        }
        echo json_encode(['success'=>$bool,'response'=>$response]);
    }else if(isset($_FILES['curriculumfile']['name'])){
        $num = 1;
        $courseid = $_SESSION['courseId'];
        $getCount = $conn->query("SELECT * FROM curriculum WHERE course_id = $courseid ORDER BY number DESC LIMIT 1");
        if($getCount->num_rows > 0){
            while($row = $getCount->fetch_assoc()){
                $num = (int)$row['number'];
            }
            $num += 1;
        }
        $csvFile = fopen($_FILES['curriculumfile']['tmp_name'], 'r');
        $bool = false;
        $response = '';
        while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE){
            $year = $getData[0];
            $sem = $getData[1];
            $course = $getData[2];
            $description = $getData[3];
            $prereq = $getData[4];
            $prereqs = $getData[4];
            if(strtolower($year) == 'year' && strtolower($sem) == 'sem' && strtolower($description) == 'description' && strtolower($prereq) == 'prerequisite'){
                $bool = true;
            }else if($bool){
                $subject = '';
                $getSubject = $conn->query("SELECT * FROM subject WHERE course_num LIKE '%$course%' AND subject_description LIKE '%$description%'");
                while($sub = $getSubject->fetch_assoc()){
                    $subject = $sub['id'];
                }
                if(strlen($prereq) != 0){
                    $prereq = explode(",",$getData[4]);
                    for($i = 0; $i < sizeof($prereq) ;$i++){
                        $str = trim($prereq[$i]);
                        $getprereq = $conn->query("SELECT * FROM subject WHERE course_num LIKE '%$str%'");
                        while($prerequisite = $getprereq->fetch_assoc()){
                            if($getSubject->num_rows != 0){
                                $pre = $prerequisite['id'];
                                if(mysqli_query($conn,"INSERT INTO curriculum(course_id,subject_id,prerequisites,year,sem,number) VALUES($courseid,$subject,$pre,$year,$sem,$num)")){
                                    $response = 'The file has been uploaded.';
                                }else{
                                    $response = "The file format is incorrect.";
                                }
                            }
                        }
                    }
                }else{
                    if($getSubject->num_rows != 0){
                        if(mysqli_query($conn,"INSERT INTO curriculum(course_id,subject_id,year,sem,number) VALUES($courseid,$subject,$year,$sem,$num)")){
                            $response = 'The file has been uploaded.';
                        }else{
                            $response = "The file format is incorrect.";
                        }
                    }
                }
            }else{
                $response = "The file format is incorrect.";
            }
        }
        echo json_encode(['success'=>$bool,'response'=>$response]);
    }else if(isset($_POST['getCourse'])){
        $getCourse = $conn->query("SELECT * FROM course WHERE institute_id = ".$_POST['getCourse']);
        while($row = $getCourse->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
?>