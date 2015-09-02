<?php
include 'lib-connection.php';
session_start();
$notice="";
if(isset($_POST['username'])&&isset($_POST['password'])){

	$password=$_POST['password'];
	$hash = md5($password);
	$sql='SELECT nama_karyawan as nama , karyawan_id , foto_karyawan
	FROM  `karyawan` 
	WHERE username =  "'.$_POST['username'].'"
	AND PASSWORD =  "'.$hash.'"
	LIMIT 1';
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
  	$query = $stmt->fetch(PDO::FETCH_ASSOC);
  	$_SESSION['login'] = $query['nama'];
  	$_SESSION['karyawan']=$query['karyawan_id'];
  	$_SESSION['foto']=$query['foto_karyawan'];
  	$notice="Login Berhasil";
  	header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
  	exit();
	}else{
		$notice ="Username atau password salah";
		header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
		exit();
	}
}else{
	$notice ="data tidak lengkap";
	header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
	exit();
}


?>