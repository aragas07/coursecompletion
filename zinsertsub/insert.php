<?php
    include('../database/DBConnection.php');
    global $conn;
    $filename=$_FILES["file"]["tmp_name"];		
        if($_FILES["file"]["size"] > 0){
            $file = fopen($filename, "r");
            $x = 0;
            while (($getData = fgetcsv($file, 100000, ",")) !== FALSE){
                $x++;
                if($x > 0){
                    $exist = $conn->query("SELECT * FROM subject WHERE course_num like '%".$getData[1]."%' AND subject_description LIKE '%".$getData[2]."%'");
                    if($exist->num_rows == 0){
                        echo $x.'<br>';
                        mysqli_query($conn,"INSERT INTO subject(course_num,subject_description,unit) VALUES('".$getData[1]."','".$getData[2]."','".$getData[3]."')");
                    }
				}
            }
            fclose($file);	
            $_SESSION['fileuploaded'] = true;
        }
?>