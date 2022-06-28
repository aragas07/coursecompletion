<?php
// function determine($conn,$pre,$year,$courseid,$number,$studid,$num){
//     global $remaining;
//     $getPre = $conn->query("SELECT * FROM curriculum INNER JOIN subject ON curriculum.subject_id = subject.id WHERE course_id = $courseid AND number = $number AND subject_id = $pre");
//     while($row = $getPre->fetch_assoc()){
//         //echo $pre.' = '.$row['prerequisites'].' - '.$row['course_num'].' = '.$row['subject_id'].'<br>';
//         $pre = $row['prerequisites'];
//         if($pre != ''){
//             $subtake = $conn->query("SELECT * FROM takes INNER JOIN subject ON takes.subject_id = subject.id WHERE student_id = '$studid' AND subject_id = $pre");
//             if($subtake->num_rows > 0){
//                 while($takes = $subtake->fetch_assoc()){
//                     if(($takes['grades'] > 3 || strtolower($takes['grades']) == 'inc') && ($takes['comply'] == '' || $takes['comply'] > 3)){
//                         $remaining = $row['year'] - 1;
//                         $num = 1;
//                     }else if($num == 0){
//                         if($takes['year'] != 4){
//                             $remaining = $row['year'] - 1;
//                         }else{
//                             $remaining = $row['year'];
//                         }
//                         $num = 1;
//                     }
//                 }
//             }
//             determine($conn,$pre,$year,$courseid,$number,$studid,$num);
//         }
//     }
// }
