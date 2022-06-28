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
        $login = $conn->query("SELECT * FROM admin WHERE username = '$username' AND password = '$pass'");
        if($login->num_rows > 0){
            echo 'success';
            $_SESSION['auth'] = true;
        }else{
            echo 'Sorry you are not able to login';
        }

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
    }
?>