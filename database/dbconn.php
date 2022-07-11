
<?php
$servername = "auth-db615.hstgr.io";
$database = "u409395717_coursecomp";
$username = "u409395717_course";
$password = "ArgieRagas@07";
// Create connection
//$conn = mysqli_connect($servername, $username, $password, $database);

$conn = new mysqli("auth-db615.hstgr.io", "u409395717_coursecomp", "ArgieRagas@07", "u409395717_course");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
echo "Connected successfully";
?>