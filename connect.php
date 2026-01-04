<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "quan_ly_cua_hang_sach";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>