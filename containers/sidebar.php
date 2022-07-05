<?php
        if(!$_SESSION['auth']){
            header("location:login.php");
        }
    ?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <a class="nav-link" id="0" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    <?php
        $getCourse = $conn->query("SELECT * FROM course WHERE id = ".$_SESSION['courseId']);
        while($row = $getCourse->fetch_assoc()){
            echo $row['name'];
        }
    ?>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <form action="database/DBManipulation.php" method="post">
                <input type="submit" value="Log out" name="logout" style="background-color:white; border:none"
                    class="logout">
            </form>
        </li>
    </ul>
</nav>

<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="assets/dist/img/dorsu.png" alt="Course completion" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Course completion</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php" id="ind" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="course.php" class="nav-link">
                        <i class="nav-icon fab fa-discourse"></i>
                        <p>Course</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="subject.php" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Subject</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="student.php" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Student</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="enrollment.php?id=" class="nav-link">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Course Admission</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="curriculum.php" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Curriculum</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="grades.php?id=" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Grades</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="deliquency.php" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Scholastic Deliquency</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>