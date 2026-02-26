<?php
$conn = mysqli_connect("localhost","root","","melody_masters_db");
if(!$conn){
  die("Database connection failed");
}
session_start();
?>
