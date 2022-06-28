<?php
include ('database/DBConnection.php');
global $conn;
$remaining = 0;
$year = 0;
$array = array();
$subId = $conn->query("SELECT * FROM curriculum WHERE course_id = 34 AND number = 1 AND sem = 1 AND year = (SELECT year FROM curriculum WHERE course_id = 34 AND number = 1 ORDER BY year DESC LIMIT 1) GROUP BY subject_id");
while($row = $subId->fetch_assoc()){
    $year = $row['year'];
    determine($conn,$row['subject_id'],$year,$array,0);
    //$remaining = $num;
    
}
function determine($conn,$pre,$year,$array,$num){
    global $remaining;
    $getPre = $conn->query("SELECT * FROM curriculum INNER JOIN subject ON curriculum.subject_id = subject.id WHERE course_id = 34 AND number = 1 AND subject_id = $pre");
    while($row = $getPre->fetch_assoc()){
        $pre = $row['prerequisites'];
        if($pre != ''){
            array_push($array,$row['subject_id']);
            echo $pre.' = '.$row['subject_id'].' - '.$row['course_num'].' = '.$row['subject_id'].' year: '.$row['year'].' sem: '.$row['sem'].'<br>';
            $subtake = $conn->query("SELECT * FROM takes INNER JOIN subject ON takes.subject_id = subject.id WHERE student_id = '2019-1506' AND subject_id = $pre");
            if($subtake->num_rows > 0){
                while($takes = $subtake->fetch_assoc()){
                    if(($takes['grades'] > 3 || strtolower($takes['grades']) == 'inc') && ($takes['comply'] == '' || $takes['comply'] > 3)){
                        $remaining = $row['year'] - 1;
                        $num = 1;
                    }else if($num == 0){
                        if($takes['year'] != 4){
                            $remaining = $row['year'] - 1;
                        }else{
                            $remaining = $row['year'];
                        }
                        $num = 1;
                    }
                }
            }
            determine($conn,$pre,$year,$array,$num);
        }
    }
}

mysqli_query($conn,"DELETE FROM course WHERE id = 68");
echo $remaining;

 
//echo 'prerequiisted '.array_search(182,array_column($subarray,'prerequisite'));
 ?>