<?php
  $conn = new mysqli("localhost", "root", "", "coursecomply");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>  