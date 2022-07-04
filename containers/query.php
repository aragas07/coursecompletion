<?php    
    include("../database/DBConnection.php");
    include_once '../database/remaining.php';
    global $conn;  
    session_start();
    
    class subject{
        public $courseno, $description, $pre, $year, $sem, $unit, $grade, $comply, $course, $subId;
    }
    
    if(isset($_POST['show'])){
        $search = $_POST['show'];
        $sql = "SELECT * FROM student INNER JOIN course on student.course_id = course.id WHERE student.id = '$search'";
        $stmt = $conn->query($sql);
        while($row = $stmt->fetch_assoc()){
            if($row['profile'] == ''){
                $profile = "assets/dist/img/profile.png";
            }else{
                $profile = "upload/".$row['profile'];
            }
            echo $row['course_id'].'||'.$row['curriculum'].'||'.$profile.'||'.$row['lname'].' '.$row['fname'].'||'.$row['bday'].'||'.$row['gender'].
            '||'.$row['email'].'||'.$row['name'].'||'.$row['course_id'].'||'.$row['curriculum'];
        }
    }else if(isset($_POST['getsubject'])){
        $subjects = array();
        $firstmid = false;
        $secondmid = false;
        $thirdmid = false;
        $fourthmid = false;
        $fifth = false;
        $courseid = $_POST['getsubject'];
        $number = $_POST['number'];
        $student = $_POST['studentid'];
        if($number == ''){$number = 0;}
        $getsub = $conn->query("SELECT * FROM curriculum AS c INNER JOIN subject AS s ON c.subject_id = s.id WHERE c.course_id = $courseid AND c.number = $number GROUP BY c.subject_id");
        
        if($getsub->num_rows > 0){
            while($row = $getsub->fetch_assoc()){
                $subject = new subject();
                $subject->courseno = $row['course_num'];
                $subject->description = $row['subject_description'];
                $subject->year = $row['year'];
                $subject->sem = $row['sem'];
                $subject->unit = $row['unit'];
                $getGrade = $conn->query("SELECT * FROM takes WHERE student_id = '$student' AND subject_id = ".$row['subject_id']);
                while($grade = $getGrade->fetch_assoc()){
                    $subject->grade = $grade['grades'];
                    $subject->comply = $grade['comply'];
                }
                $getPre = $conn->query("SELECT * FROM curriculum AS c INNER JOIN subject AS s ON c.prerequisites = s.id WHERE c.course_id = $courseid AND number = $number AND subject_id = ".$row['subject_id']." GROUP BY course_num");
                
                $pre = '';
                $count = 0;
                while($getpre = $getPre->fetch_assoc()){
                    $count++;
                    if($getPre->num_rows > $count){
                        $pre .= $getpre['course_num'].', ';
                    }else{
                        $pre .= $getpre['course_num'];
                    }
                }
                $subject->pre = $pre;
                $count = 0;
                if($row['year'] == 1.5){$firstmid = true;}
                if($row['year'] == 2.5){$secondmid = true;}
                if($row['year'] == 3.5){$thirdmid = true;}
                if($row['year'] == 4.5){$fourthdmid = true;}
                if($row['year'] == 5){$fifth = true;}
                array_push($subjects,$subject);
            }
            echo '<div class="table-div">
                <style>
                    .table{
                        text-indent: initial;
                        border-spacing: 2px;
                        border-collapse: collapse;
                    }
                    .table-bordered td, .table-bordered th {
                        border: 1px solid #dee2e6;
                    }
                    .table td, .table th {
                        padding: 0.75rem;
                        vertical-align: top;
                        border-top: 1px solid #dee2e6;
                    }
                    th {
                        text-align: inherit;
                        font-weight: bold;
                        display: table-cell;
                    }
                    .descrip{
                        min-width: 250px;
                        width: 250px;
                    }
                </style>
                <h2>1st year</h2>
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
                                            <th style="width:100px">Course no.</th>
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                        $total = 0;
                                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                            if($subjects[$ind]->sem == 1 && $subjects[$ind]->year == 1){ 
                                                $total += $subjects[$ind]->unit; 
                                                echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                            }
                                        }
                                    echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                            <th>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:100px">course no.</th>
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                        $total = 0;
                                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                            if($subjects[$ind]->sem == 2 && $subjects[$ind]->year == 1){
                                                $total += $subjects[$ind]->unit;
                                                echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                            }
                                        }
                                    echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>';
            if($firstmid){
                echo '<div class="table-div">
                    <h2>Mid year</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course no.</th>
                                <th class="descrip">Description</th>
                                <th>Unit</th>
                                <th style="width:150px">Prerequisites</th>';
                                if($student != ''){
                                    echo '<th style="width:100px">Grade</th>
                                    <th hidden>Comply grade</th>';
                                }
                            echo '</tr>
                        </thead>
                        <tbody>';
                        $total = 0;
                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                            if($subjects[$ind]->year == 1.5){
                                $total += $subjects[$ind]->unit;
                                echo '<tr>
                                        <td>'.$subjects[$ind]->courseno.'</td>
                                        <td>'.$subjects[$ind]->description.'</td>
                                        <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                        <td>'.$subjects[$ind]->pre.'</td>';
                                        if($student != ''){
                                            echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                            <td hidden>'.$subjects[$ind]->comply.'</td>';
                                        }
                                    echo '</tr>';
                            }
                        }
                        echo '</tbody>
                    </table>
                    <div class="right">
                        <label>Total unit:</label>
                        <input type="text" class="t-unit" disabled value="'.$total.'">
                    </div>
                </div>';
            }
            echo '<div class="table-div">
                <h2>2nd year</h2>
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
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                    $total = 0;
                                    for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                        if($subjects[$ind]->sem == 1 && $subjects[$ind]->year == 2){
                                            $total += $subjects[$ind]->unit;
                                            echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                        }
                                    }
                                echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                            <th>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:100px">course no.</th>
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                    $total = 0;
                                    for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                        if($subjects[$ind]->sem == 2 && $subjects[$ind]->year == 2){
                                            $total += $subjects[$ind]->unit;
                                            echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                        }
                                    }
                                echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>';
            if($secondmid){
                echo '<div class="table-div">
                    <h2>Mid year</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course no.</th>
                                <th class="descrip">Description</th>
                                <th>Unit</th>
                                <th style="width:150px">Prerequisites</th>';
                                if($student != ''){
                                    echo '<th style="width:100px">Grade</th>
                                    <th hidden>Comply grade</th>';
                                }
                            echo '</tr>
                        </thead>
                        <tbody>';
                        $total = 0;
                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                            if($subjects[$ind]->year == 2.5){
                                $total += $subjects[$ind]->unit;
                                echo '<tr>
                                        <td>'.$subjects[$ind]->courseno.'</td>
                                        <td>'.$subjects[$ind]->description.'</td>
                                        <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                        <td>'.$subjects[$ind]->pre.'</td>';
                                        if($student != ''){
                                            echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                            <td hidden>'.$subjects[$ind]->comply.'</td>';
                                        }
                                    echo '</tr>';
                            }
                        }
                        echo '</tbody>
                    </table>
                    <div class="right">
                        <label>Total unit:</label>
                        <input type="text" class="t-unit" disabled value="'.$total.'">
                    </div>
                </div>';
            }
            echo '<div class="table-div">
                <h2>3rd year</h2>
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
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                    $total = 0;
                                    for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                        if($subjects[$ind]->sem == 1 && $subjects[$ind]->year == 3){
                                            $total += $subjects[$ind]->unit;
                                            echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                        }
                                    }
                                echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                            <th>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:100px">course no.</th>
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                    $total = 0;
                                    for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                        if($subjects[$ind]->sem == 2 && $subjects[$ind]->year == 3){
                                            $total += $subjects[$ind]->unit;
                                            echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                        }
                                    }
                                echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>';
            if($thirdmid){
                echo '<div class="table-div">
                    <h2>Mid year</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course no.</th>
                                <th class="descrip">Description</th>
                                <th>Unit</th>
                                <th style="width:150px">Prerequisites</th>';
                                if($student != ''){
                                    echo '<th style="width:100px">Grade</th>
                                    <th hidden>Comply grade</th>';
                                }
                            echo '</tr>
                        </thead>
                        <tbody>';
                        $total = 0;
                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                            if($subjects[$ind]->year == 3.5){
                                $total += $subjects[$ind]->unit;
                                echo '<tr>
                                        <td>'.$subjects[$ind]->courseno.'</td>
                                        <td>'.$subjects[$ind]->description.'</td>
                                        <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                        <td>'.$subjects[$ind]->pre.'</td>';
                                        if($student != ''){
                                            echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                            <td hidden>'.$subjects[$ind]->comply.'</td>';
                                        }
                                    echo '</tr>';
                            }
                        }
                        echo '</tbody>
                    </table>
                    <div class="right">
                        <label>Total unit:</label>
                        <input type="text" class="t-unit" disabled value="'.$total.'">
                    </div>
                </div>';
            }
            echo '<div class="table-div">
                <h2>4th year</h2>
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
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                    $total = 0;
                                    for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                        if($subjects[$ind]->sem == 1 && $subjects[$ind]->year == 4){
                                            $total += $subjects[$ind]->unit;
                                            echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                        }
                                    }
                                echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                            <th>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:100px">course no.</th>
                                            <th class="descrip">Description</th>
                                            <th style="width:75px">Unit</th>
                                            <th style="width:150px">Prerequisites</th>';
                                            if($student != ''){
                                                echo '<th style="width:100px">Grade</th>
                                                <th hidden>Comply grade</th>';
                                            }
                                        echo '</tr>
                                    </thead>
                                    <tbody>';
                                    $total = 0;
                                    for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                        if($subjects[$ind]->sem == 2 && $subjects[$ind]->year == 4){
                                            $total += $subjects[$ind]->unit;
                                            echo '<tr>
                                                    <td>'.$subjects[$ind]->courseno.'</td>
                                                    <td>'.$subjects[$ind]->description.'</td>
                                                    <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                    <td>'.$subjects[$ind]->pre.'</td>';
                                                    if($student != ''){
                                                        echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                        <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                    }
                                                echo '</tr>';
                                        }
                                    }
                                echo '</tbody>
                                </table>
                                <div class="right">
                                    <label>Total unit:</label>
                                    <input type="text" class="t-unit" disabled value="'.$total.'">
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>';
            
            if($fourthmid){
                echo '<div class="table-div">
                    <h2>Mid year</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course no.</th>
                                <th class="descrip">Description</th>
                                <th>Unit</th>
                                <th style="width:150px">Prerequisites</th>';
                                if($student != ''){
                                    echo '<th style="width:100px">Grade</th>
                                    <th hidden>Comply grade</th>';
                                }
                            echo '</tr>
                        </thead>
                        <tbody>';
                        $total = 0;
                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                            if($subjects[$ind]->year == 4.5){
                                $total += $subjects[$ind]->unit;
                                echo '<tr>
                                        <td>'.$subjects[$ind]->courseno.'</td>
                                        <td>'.$subjects[$ind]->description.'</td>
                                        <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                        <td>'.$subjects[$ind]->pre.'</td>';
                                        if($student != ''){
                                            echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                            <td hidden>'.$subjects[$ind]->comply.'</td>';
                                        }
                                    echo '</tr>';
                            }
                        }
                        echo '</tbody>
                    </table>
                    <div class="right">
                        <label>Total unit:</label>
                        <input type="text" class="t-unit" disabled value="'.$total.'">
                    </div>
                </div>';
            }
            if($fifth){
                echo '<div class="table-div">
                    <h2>5th year</h2>
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
                                                <th class="descrip">Description</th>
                                                <th style="width:75px">Unit</th>
                                                <th style="width:150px">Prerequisites</th>';
                                                if($student != ''){
                                                    echo '<th style="width:100px">Grade</th>
                                                    <th hidden>Comply grade</th>';
                                                }
                                            echo '</tr>
                                        </thead>
                                        <tbody>';
                                        $total = 0;
                                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                            if($subjects[$ind]->sem == 1 && $subjects[$ind]->year == 5){
                                                $total += $subjects[$ind]->unit;
                                                echo '<tr>
                                                        <td>'.$subjects[$ind]->courseno.'</td>
                                                        <td>'.$subjects[$ind]->description.'</td>
                                                        <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                        <td>'.$subjects[$ind]->pre.'</td>';
                                                        if($student != ''){
                                                            echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                            <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                        }
                                                    echo '</tr>';
                                            }
                                        }
                                    echo '</tbody>
                                    </table>
                                    <div class="right">
                                        <label>Total unit:</label>
                                        <input type="text" class="t-unit" disabled value="'.$total.'">
                                    </div>
                                </th>
                                <th>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width:100px">course no.</th>
                                                <th class="descrip">Description</th>
                                                <th style="width:75px">Unit</th>
                                                <th style="width:150px">Prerequisites</th>';
                                                if($student != ''){
                                                    echo '<th style="width:100px">Grade</th>
                                                    <th hidden>Comply grade</th>';
                                                }
                                            echo '</tr>
                                        </thead>
                                        <tbody>';
                                        $total = 0;
                                        for($ind = 0; $ind < sizeof($subjects) ; $ind++){
                                            if($subjects[$ind]->sem == 2 && $subjects[$ind]->year == 5){
                                                $total += $subjects[$ind]->unit;
                                                echo '<tr>
                                                        <td>'.$subjects[$ind]->courseno.'</td>
                                                        <td>'.$subjects[$ind]->description.'</td>
                                                        <td style="text-align:center">'.$subjects[$ind]->unit.'</td>
                                                        <td>'.$subjects[$ind]->pre.'</td>';
                                                        if($student != ''){
                                                            echo '<td style="text-align:center">'.$subjects[$ind]->grade.'</td>
                                                            <td hidden>'.$subjects[$ind]->comply.'</td>';
                                                        }
                                                    echo '</tr>';
                                            }
                                        }
                                    echo '</tbody>
                                    </table>
                                    <div class="right">
                                        <label>Total unit:</label>
                                        <input type="text" class="t-unit" disabled value="'.$total.'">
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>';
            }
        }else{
            echo '<h1 style="font-weight: 900; color: red">There is no curriculum available in this course</h1>';
        }
    }else if(isset($_POST['yearselection'])){
        $getyear = $conn->query("SELECT * FROM takes WHERE student_id = '".$_POST['yearselection']."' GROUP BY year");
        $i = 0;
        while($row = $getyear->fetch_assoc()){
            $i++;
            echo '<option '; if($i === $getyear->num_rows) {echo 'selected ';} echo 'value="'.$row['year'].'">'.$row['year'].' year</option>';
        }
    }else if(isset($_POST['disStudent'])){
        $search = $_POST['disStudent'];
        $page = $_POST['page'];
        $page = max($page-1,0);
        $page = $page*10;
        $courseid = $_SESSION['courseId'];
        $getStud = $conn->query("SELECT * FROM student WHERE (id LIKE '%$search%' OR fname LIKE '%$search%' OR mname LIKE '%$search%' OR lname LIKE '%$search%') AND (course_id = $courseid OR course_id IS NULL) ORDER BY year ASC LIMIT $page,10");
        while($row = $getStud->fetch_assoc()){
            echo '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['fname'].'</td>
                <td>'.$row['mname'].'</td>
                <td>'.$row['lname'].'</td>
                <td>'.$row['bday'].'</td>
                <td>'.$row['gender'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['year'].'</td>';
                if($row['curriculum'] == ''){
                    echo '<td><a href="enrollment.php?id='.$row['id'].'" style="width:100%" class="btn btn-default">ADMIT</a></td>';
                }else{
                    echo '<td><button class="btn btn-success enrolled" style="width:100%" id="'.$row['id'].'||'.$row['course_id'].'||'.$row['curriculum'].'" data-toggle="modal" data-target="#enrol">ADMITTED</button></td>';
                }
            echo '</tr>';
        }
    }else if(isset($_POST['course'])){
        $course = $_POST['course'];
        $ins = $_POST['ins'];
        $getCourse = $conn->query("SELECT * FROM course WHERE name LIKE '%$course%'");
        if($getCourse->num_rows > 0){
            echo 'exist';
        }else{
            if(mysqli_query($conn,"INSERT INTO course(name,institute_id) values('$course','$ins')")){
                echo 'success';
            }else{ echo 'error';}
        }
    }else if(isset($_POST['displaycourse'])){
        $getInstitute = $conn->query("SELECT * FROM institute ORDER BY name ASC");
        while($institute = $getInstitute->fetch_assoc()){
            echo '<div style="border-bottom: 1px solid gray;margin-bottom:47px;"><h2>'.$institute['name'].'</h2>
            <div class="row">';
            $getCourse = $conn->query("SELECT * FROM course where institute_id = ".$institute['id']." order by name asc");
            while($course = $getCourse->fetch_assoc()){
                $getSCount = $conn->query("SELECT count(*) AS total FROM course INNER JOIN student ON course.id = student.course_id WHERE student.course_id = ".$course['id']);
                while($count = $getSCount->fetch_assoc()){
                    $co = $count['total'];
                }
                echo '<div class="col-lg-3 col-6 box">
                    <a>
                        <div class="small-box bg-course">
                            <div class="inner">
                                <h4>'.$course['name'].'</h4>
                                <p>Student count: '.$co.'</p>
                            </div>
                        </div>
                    </a>
                    </div>';
            }
            echo '</div></div>';
        }
    }else if(isset($_POST['pre'])){
        echo '<option value="">---choose---</option>';
        $getSub = $conn->query("SELECT * FROM subject AS s INNER JOIN curriculum AS cu INNER JOIN course AS co ON s.id = cu.Subject_id AND cu.course_id = co.id WHERE co.id = ".$_POST['pre']);
        while($row = $getSub->fetch_assoc()){
            echo '<option value="'.$row['Subject_id'].'">'.$row['course_num'].' - '.$row['subject_description'].'</option>';
        }
    }else if(isset($_POST['showsubject'])){
        $search = $_POST['showsubject'];
        $page = $_POST['page'];
        $page = max($page-1,0);
        $page = $page*10;
        $getSubject = $conn->query("SELECT * FROM subject WHERE course_num LIKE '%$search%' OR subject_description LIKE '%$search%' LIMIT $page,10");
        while($row = $getSubject->fetch_assoc()){
            echo '<tr>
                <td>'.$row['course_num'].'</td>
                <td>'.$row['subject_description'].'</td>
                <td>'.$row['unit'].'</td>
            </tr>';
        }
    }else if(isset($_POST['loadsubject'])){
        $getSubject = $conn->query("SELECT * FROM subject");
        echo '<option value="0">--CHOOSE SUBJECT--</option>';
        while($row = $getSubject->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['course_num'].' &nbsp; - &nbsp;&nbsp; '.$row['subject_description'].'</option>';
        }
    }else if(isset($_POST['getPre'])){
        $getSubject = $conn->query("SELECT * FROM subject ORDER BY unit ASC");
        echo '<option value="0">prerequisites</option>';
        while($row = $getSubject->fetch_assoc()){
            if(strlen($row['course_num']) > 0) echo '<option value="'.$row['id'].'">'.$row['course_num'].'</option>';
        }
    }else if(isset($_POST['subject'])){
        if($_POST['prere'] == 0){
            if(mysqli_query($conn,"INSERT INTO curriculum(course_id,subject_id,sem,year,number) VALUES(".$_POST['courseid'].",".$_POST['subject'].",".$_POST['sem'].",".$_POST['year'].",".$_POST['num'].")")){
                echo 'success';
            }
        }else{
            if(mysqli_query($conn,"INSERT INTO curriculum(course_id,subject_id,prerequisites,sem,year,number) VALUES(".$_POST['courseid'].",".$_POST['subject'].",".$_POST['prere'].",".$_POST['sem'].",".$_POST['year'].",".$_POST['num'].")")){
                echo 'success';
            }else{echo 'error';}
        }
    }else if(isset($_POST['getcurnum'])){
        $getCount = $conn->query("SELECT * FROM curriculum WHERE course_id = ".$_POST['getcurnum']." ORDER BY number DESC LIMIT 1");
        if($getCount->num_rows > 0){
            while($row = $getCount->fetch_assoc()){
                $num = (int)$row['number'];
            }
            echo $num += 1;
        }else{
            echo '1';
        }
    }else if(isset($_POST['getAllcurrOfCourse'])){
        $search = $_POST['getAllcurrOfCourse'];
        $getcur = $conn->query("SELECT * FROM curriculum WHERE course_id = $search GROUP BY number ORDER BY number ASC");
        while($row = $getcur->fetch_assoc()){
            echo '<option value="'.$row['number'].'">Curriculum #'.$row['number'].'</option>';
        }
    }else if(isset($_POST['enrolled'])){
        if(mysqli_query($conn,"UPDATE student SET course_id = ".$_POST['enrolled'].", curriculum = ".$_POST['cur']." WHERE id = '".$_POST['studentId']."'")){
            echo 'success';
        }else{
            echo 'error';
        }
    }else if(isset($_POST['getCourseName'])){
        $getName = $conn->query("SELECT * FROM course WHERE id = ".$_POST['getCourseName']);
        while($row = $getName->fetch_assoc()){
            echo $row['name'];
        }
    }else if(isset($_POST['takenSubject'])){
        $courseid = $_POST['takenSubject'];
        $number = $_POST['number'];
        $years = array('1st','2nd','3rd','4th','5th','6th','7th');

        for($i = 0; $i < $_POST['loop'] ;$i++){
            $j = 0;
            echo '<tr>
                <td> <select class="form-control select-year">'; 
                $getSubject = $conn->query("SELECT * FROM curriculum WHERE course_id = $courseid AND number = $number GROUP BY year");
                while($subject = $getSubject->fetch_assoc()){
                    echo '<option value="'.$subject['year'].'">'.$years[$j].' year</option>';
                    $j++;
                }
            echo '</select></td>
                <td> <select class="form-control select-sem">
                <option value="1">1st sem</option>
                <option value="2">2nd sem</option>
                </select></td>
                <td class="subject-cont"> </td>
                <td style="width: 150px">
                    <select name="" class="form-control input-grades">
                        <option value="1.00">1.00</option>
                        <option value="1.25">1.25</option>
                        <option value="1.50">1.50</option>
                        <option value="1.75">1.75</option>
                        <option value="2.00">2.00</option>
                        <option value="2.25">2.25</option>
                        <option value="2.50">2.50</option>
                        <option value="2.75">2.75</option>
                        <option value="3.00">3.00</option>
                        <option value="5.00">5.00</option>
                        <option value="WIP">WIP</option>
                    </select>
                </td>
            </tr>';
        }
    }else if(isset($_POST['displayTaken'])){
        $emailGrades = ''; //changes 02-27-2021

        $sid = $_POST['displayTaken'];
        $years = array('1st','2nd','3rd','4th','5th','6th','7th','8th','9th','10th','11th','12th','13th');
        $getYear = $conn->query("SELECT * FROM takes WHERE student_id = '$sid' GROUP BY year");
        $i = 0;
        while($year = $getYear->fetch_assoc()){
            $emailGrades = '<div id="emailGrades" style="display: none;"><div>';
            $getSem = $conn->query("SELECT * FROM takes WHERE student_id = '$sid' AND year = ".$year['year']." GROUP BY sem");
            echo '<h2 class="col-md-12">'.$years[$i].' year</h2>';
            $emailGrades .= '<h2>'.$years[$i].' year</h2>
                <div style="display: flex;">'; //changes 02-27-2021
            $i++;
            $j = 0;
            while($sem = $getSem->fetch_assoc()){
                $total = 0;
                $unit = 0;
                $getSub = $conn->query("SELECT *,takes.id AS tid  FROM takes INNER JOIN subject ON takes.subject_id = subject.id WHERE student_id = '$sid' AND year = ".$sem['year']." AND sem = ".$sem['sem']);
                echo '<div class="col-md-6"><i style="font-weight: 900">'.$years[$j].' sem</i>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Course no.</td>
                                <td>Description</td>
                                <td>Units</td>
                                <td>Final grades</td>
                                <td hidden>Comply grades</td>
                            </tr>
                        </thead>
                        <tbody>';
                $emailGrades .= '<div style="width: 100%; ~MR-50~">
                        <i style="font-weight: 900">'.$years[$j].' sem</i>
                        <table style="border-collapse: collapse;">
                            <thead>
                                <tr style="background: #333;">
                                    <th style="width: 20%; padding: 10px; text-align: left; font-weight: 600; border: 1px solid #ddd; color: #fff;">Course no.</th>
                                    <th style="width: 60%; padding: 10px; text-align: left; font-weight: 600; border: 1px solid #ddd; color: #fff;">Description</th>
                                    <th style="width: 60%; padding: 10px; text-align: left; font-weight: 600; border: 1px solid #ddd; color: #fff;">Units</th>
                                    <th style="width: 10%; padding: 10px; text-align: left; font-weight: 600; border: 1px solid #ddd; color: #fff;">Final grades</th>';
                                    //'<th hidden style="width: 10%; padding: 10px; text-align: left; font-weight: 600; border: 1px solid #ddd; color: #fff;">Comply grades</th>
                $emailGrades .= '</tr>
                            </thead>
                            <tbody>'; //changes 02-27-2021
                            $gpa = 0;
                            $num = 0;
                        while($row = $getSub->fetch_assoc()){
                            if($row['grades'] >= '1.00' && $row['grades'] <= '5.00'){
                                $gpa += $row['unit'] * floatval($row['grades']);
                                $num++;
                            }
                            echo '<tr>
                                <td>'.$row['course_num'].'</td>
                                <td>'.$row['subject_description'].'</td>
                                <td>'.$row['unit'].'</td>
                                <td id="'.$row['tid'].'" class="'.$years[$i].'and'.$years[$j].'">'.$row['grades'].'</td>
                                <td hidden>';
                            $emailGrades .= '<tr>
                                <td style="padding: 10px; border: 1px solid #ddd;">'.$row['course_num'].'</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">'.$row['subject_description'].'</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">'.$row['unit'].'</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">'.$row['grades'].'</td>';
                                //<td hidden style="padding: 10px; border: 1px solid #ddd;">'; changes 02-27-2021

                           
                            if ($row['comply'] == '' && (strtolower($row['grades']) == 'inc' || strtolower($row['grades']) == 'wip' || $row['grades'] == 4)){
                                //echo '<input id="'.$row['tid'].'" class="comp-grades form-control" type="number"/>';
                                $emailGrades .= $row['tid']; //changes 02-27-2021
                                $unit += $row['unit'];
                            } else if($row['comply'] == 5 || $row['grades'] == 5){
                                $unit += $row['unit'];
                                echo $row['comply'];
                                $emailGrades .= $row['comply']; //changes 02-27-2021

                            } else {
                                echo $row['comply'];
                                $emailGrades .= $row['comply']; //changes 02-27-2021

                            }
                            echo '</td>
                            </tr>';
                            $emailGrades .= '</td>
                            </tr>';  //changes 02-27-2021
                            $total += $row['unit'];
                            $avg = round($gpa/$total, 2);
                        }

                        echo '</tbody>
                    </table>
                    <div class="justify-content-between row mr-2 ml-3">';
                        $emailGrades .= '</tbody>
                    </table>
                    <div style="display: flex;">';  //changes 02-27-2021

                    echo '<div class="row"> 
                    <label>Total unit\'s not passed:</label>
                    <input type="text" value="'.$unit.'" disabled class="form-control mr-4 ml-1 col-sm-1 form-control-sm"> 
                    <label>Total unit: <input type="text" class="t-unit mr-5" disabled value="'.$total.'"></label>
                    <label class="right" hiddenf>GWA: <input type="text" class="t-unit" disabled value="'.$avg.'"></label>
                </div>
                <button id="'.$years[$i].'and'.$years[$j].'" class="btn btn-secondary mb-3 edit-grades-btn">Edit</button>';
            $emailGrades .= '<div style="display: flex; width: 50%;"> 
                                <p style="margin-right: 5px;">Total unit\'s not passed:</p>
                                <p style="border: 1px solid #ddd; padding: 0px 8px; border-radius: 5px; font-weight: 700;">'.$unit.'</p>
                            </div>'; //changes 02-27-2021

                    if ($unit != 0) {
                        if($unit >= 21*0.25 && $unit <= 21*0.49){
                            echo '<h4 style="color: red; font-weight: 700" class="warning float-right">WARNING!</h4>';
                            $emailGrades .= '<h4 style="color: red; font-weight: 700">WARNING!</h4>'; //changes 02-27-2021

                        }else if($unit >= 21*0.50 && $unit <= 21*0.75){
                            echo '<h4 style="color: red; font-weight: 700" class="warning float-right">PROBATION!</h4>';
                            $emailGrades .= '<h4 style="color: red; font-weight: 700">PROBATION!</h4>'; //changes 02-27-2021

                        }else if($unit >= 21*0.76){
                            echo '<h4 style="color: red; font-weight: 700" class="warning float-right">DEBARMENT!</h4>';
                            $emailGrades .= '<h4 style="color: red; font-weight: 700">DEBARMENT!</h4>'; //changes 02-27-2021

                        }
                    }
                    echo '</div>
                    </div>';
                    $emailGrades .= '<div style="display: flex; width: 50%;">
                                        <p style="margin-right: 5px;">Total unit:</p>
                                        <p style="border: 1px solid #ddd; padding: 0px 8px; border-radius: 5px; font-weight: 700;">'.$total.'</p>
                                    </div>
                        </div>
                    </div>'; //changes 02-27-2021

                $j++;
            }
        }
        mysqli_query($conn,"UPDATE student SET year = $i WHERE id = '$sid'");
        $emailGrades .= '</div>
            </div></div>'; //changes 02-27-2021
        $emailGrades = preg_replace('/~MR-50~/', 'margin-right: 50px', $emailGrades, (substr_count($emailGrades, '~MR-50~') - 1)); //changes 02-27-2021
        $emailGrades = str_replace('~MR-50~', '', $emailGrades); //changes 02-27-2021
        echo $emailGrades; //changes 02-27-2021
    }else if(isset($_POST['searchstudent'])){
        $getStud = $conn->query("SELECT * FROM student WHERE id = '".$_POST['searchstudent']."'");
        if($getStud->num_rows > 0){
            while($row = $getStud->fetch_assoc()){
                if($row['profile'] == ''){
                    $profile = "assets/dist/img/profile.png";
                }else{
                    $profile = "upload/".$row['profile'];
                }
                $gender = $row['gender'];
                echo $row['curriculum'].'||
                <form id="info-form">
                    <div class="row">
                        <div class="col-sm-4">
                            <img id="pro-image" src="'.$profile.'" class="col-md-11" style="margin-bottom: 15px;">
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label class="col-sm-12 fol-form-label">ID :
                                    <input type="text" id="stud-id" disabled value="'.$row['id'].'" class="form-control">
                                    <input type="text" hidden name="studid" value="'.$row['id'].'">
                                </label>
                                <label class="col-sm-12 fol-form-label">First name :
                                    <input type="text" value="'.$row['fname'].'" name="fname" class="form-control">
                                </label>
                                <label class="col-sm-12 fol-form-label">Middle name :
                                    <input type="text" value="'.$row['mname'].'" name="mname" class="form-control">
                                </label>
                                <label class="col-sm-12 fol-form-label">Last name :
                                    <input type="text" value="'.$row['lname'].'" name="lname" class="form-control">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 fol-form-label">Birth date :</label>
                        <div class="col-sm-4">
                            <input type="date" value="'.$row['bday'].'" name="bday" class="form-control">
                        </div>
                        <label class="col-sm-2 fol-form-label">Sex :</label>
                        <div class="col-sm-4">
                        <select name="gender" class="form-control">
                            <option';
                            if($gender == 'Male'){echo ' selected';} echo ' value="Male">Male</option>
                            <option';
                            if($gender == 'Female'){echo ' selected';} echo ' value="Female">Female</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 fol-form-label">Address :</label>
                        <div class="col-sm-10">
                            <input name="address" value="'.$row['address'].'" type="text" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 fol-form-label">Email :</label>
                        <div class="col-sm-10">
                            <input name="email" value="'.$row['email'].'" type="email" required class="form-control">
                        </div>
                    </div>
                </form>||'.$row['course_id'].'||';
                $getIns = $conn->query("SELECT i.id AS iid, i.name AS name FROM course AS c INNER JOIN institute AS i ON c.institute_id = i.id WHERE c.id = ".$row['course_id']);
                while($getins = $getIns->fetch_assoc()){
                    echo $getins['iid'];
                }
            }
        }else{
            echo '||<div class="row">
                <div class="col-sm-4">
                    <img id="pro-image" src="assets/dist/img/profile.png" class="col-md-11" style="margin-bottom: 15px;">
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label class="col-sm-12 fol-form-label">ID :
                            <input id="stud-id" type="text" disabled class="form-control">
                        </label>
                        <label class="col-sm-12 fol-form-label">First name :
                            <input type="text" disabled class="form-control">
                        </label>
                        <label class="col-sm-12 fol-form-label">Middle name :
                            <input type="text" disabled class="form-control">
                        </label>
                        <label class="col-sm-12 fol-form-label">Last name :
                            <input type="text" disabled class="form-control">
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 fol-form-label">Birth date :</label>
                <div class="col-sm-4">
                    <input disabled type="text" class="form-control">
                </div>
                <label class="col-sm-2 fol-form-label">Sex :</label>
                <div class="col-sm-4">
                    <input disabled type="text" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 fol-form-label">Address :</label>
                <div class="col-sm-10">
                    <input disabled type="text" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 fol-form-label">Email :</label>
                <div class="col-sm-10">
                    <input disabled type="email" class="form-control">
                </div>
            </div>||';
        }
    }else if(isset($_POST['subjectpaging'])){
        $search = $_POST['searching'];
        $start = $_POST['subjectpaging'];
        $ap = $start;
        $courseid = $_SESSION['courseId'];
        if($_POST['type'] == 'subject'){
            $getCount = $conn->query("SELECT * FROM subject WHERE course_num LIKE '%$search%' OR subject_description LIKE '%$search%'");
        }else{
            $getCount = $conn->query("SELECT * FROM student WHERE (id LIKE '%$search%' OR fname LIKE '%$search%' OR mname LIKE '%$search%' OR lname LIKE '%$search%') AND (course_id = $courseid OR course_id IS NULL)");
        }
        $count = $getCount->num_rows/10;
        $count = ceil($count);
        $start = max($start - 4, 0);
        if($start == 0){$start = 1;}
        if($count < 8){$pagecount = $count;$start = 1;}
        else if($start > ($count - 7)){$pagecount = $count; $start = $count - 6;}
        else{$pagecount = $start + 7;}
        echo '<li class="page-item"><a class="page-link 0" href="#">«</a></li>';
        $j = 0;
        for($i = $start; $i <= $pagecount ;$i++){
            if($ap == $j){$active = "page-item active";$ap++;}
            else if($ap == $i){$active = "page-item active";}
            else if($ap == $i+1 && $ap == $count+1){$active = "page-item active";}
            else{$active = "page-item";}
            echo '<li class="'.$active.'"><a class="page-link '.$i.'" href="#">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link '.$count.'" href="#">»</a></li>';
    }else if(isset($_POST['fetchSubject'])){
        $courseid = $_POST['fetchSubject'];
        $number = $_POST['number'];
        $year = $_POST['year'];
        $sem = $_POST['semester'];
        echo '<select class="form-control select-subject">';
            $getSubject = $conn->query("SELECT * FROM curriculum AS c INNER JOIN subject AS s ON c.subject_id = s.id WHERE course_id = $courseid AND number = $number AND year = $year AND sem = $sem;");
            while($subject = $getSubject->fetch_assoc()){
                echo '<option value="'.$subject['id'].'">'.$subject['course_num'].' - '.$subject['subject_description'].' year</option>';
            }
        echo '</select>';
    }else if(isset($_POST['remaining'])){
        $courseid = $_POST['remaining'];
        $number = $_POST['number'];
        $studid = $_POST['studentid'];
        $remaining = 0;
        $year = 0;
        $subId = $conn->query("SELECT * FROM curriculum WHERE course_id = $courseid AND number = $number AND sem = 1 AND year = (SELECT year FROM curriculum WHERE course_id = $courseid AND number = $number ORDER BY year DESC LIMIT 1) GROUP BY subject_id");
        while($row = $subId->fetch_assoc()){
            $year = $row['year'];
            // determine($conn,$row['subject_id'],$year,$courseid,$number,$studid,0);
        }
        $total = 0;
        $unit = $conn->query("SELECT * FROM takes AS t INNER JOIN subject AS s ON t.subject_id = s.id WHERE student_id = '$studid'");
        while($row = $unit->fetch_assoc()){
            if($row['grades'] >= 1 && $row['grades'] <= 3){
                $total += intval($row['unit']);
            }
        }
        $totalunit = $conn->query("SELECT sum(unit) AS total FROM curriculum AS c INNER JOIN subject AS s ON c.subject_id = s.id WHERE course_id = $courseid AND number = $number");
        while($row = $totalunit->fetch_assoc()){
            if(intval($row['total'])*0.14 > $total || intval($row['total'])*0.28 > $total){
                $remaining = -1;
            }else if(intval($row['total'])*0.56 > $total){
                $remaining = 1;
            }else if(intval($row['total'])*0.83 > $total){
                $remaining = 2;
            }else{
                $remaining = 3;
            }
        }
        echo $year - $remaining;
    }
?>