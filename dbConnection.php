<?php
$server = 'localhost';
$dbusername = 'root';
$dbpassword = 'root';
$dbname = 'ela';
$currUserID = 2;
// Create connection

$conn = new mysqli($server, $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno())
{
  echo "Could not connect to the database!";
  exit;
}

?>
