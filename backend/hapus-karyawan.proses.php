<?php
session_start();
include 'lib-connection.php';

if($_SESSION['karyawan']==2 && isset($_POST)){
$id=$_GET['id'];
$sql="DELETE FROM `karyawan` WHERE karyawan_id = ".$id;
$stmt=$dbh->prepare($sql);
$stmt->execute();
$notice = "Karyawan berhasil di hapus";
$content="admin";
header('Location: http://manajemen-tugas.dev/index?notice='.$notice.'&content='.$content);
}else{
	$notice = "You re not super user!!";
	header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
}


?>