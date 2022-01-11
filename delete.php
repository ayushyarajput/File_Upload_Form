<?php
include 'db_config.php';
$id = $_GET['userid']; 
$sqld = "SELECT file_name from upi where userid='$id'";
$res=mysqli_query($conn,$sqld);
$row = mysqli_fetch_assoc($res);
$fn = $row['file_name'];
$sql="delete from upi where userid='$id'";
$del = mysqli_query($conn,$sql); 
unlink('user_files/'.$fn);
if($del){
    header("location:index.php");
}
?>