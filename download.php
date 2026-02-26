<?php
include 'includes/db.php';
if(!isset($_SESSION['user_id'])) die("Unauthorized");

$file = basename($_GET['file']);
$path = "assets/digital/".$file;

if(file_exists($path)){
  header('Content-Disposition: attachment; filename='.$file);
  readfile($path);
}else{
  echo "File not found";
}
