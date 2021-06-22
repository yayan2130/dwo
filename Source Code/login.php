<?php 
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];
 
$sql = mysqli_query($mysqli, "select * from login where username='$username' and password='$password'");
$cek = mysqli_num_rows($sql);
 
if($cek > 0){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['status'] = "login";
	header("location:example.php");
}else{
	header("location:index.php");	
}

?>