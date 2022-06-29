<?php
  $conn = new mysqli("localhost", "root", "", "coursecompletion");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>  