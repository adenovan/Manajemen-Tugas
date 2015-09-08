<?php
session_start();
include 'lib-connection.php';

if($_SESSION['karyawan']==2 && isset($_POST)){
$user=$_POST['tambah-user'];
$password=md5($_POST['tambah-password']);
$nama=$_POST['tambah-nama'];
$jabatan=$_POST['tambah-jabatan'];
$foto="/img/default.png";
$sql="INSERT INTO `karyawan` VALUES (null,'".$nama."','".$foto."','".$jabatan."','".$user."','".$password."')";
$stmt=$dbh->prepare($sql);
$stmt->execute();
$notice = "Karyawan berhasil di tambahkan";
$content="admin";
header('Location: http://manajemen-tugas.dev/index?notice='.$notice.'&content='.$content);
}else{
	$notice = "You re not super user!!";
	header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
}


?>