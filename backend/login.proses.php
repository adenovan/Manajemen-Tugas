<?php
include 'lib-connection.php';
session_start();
$notice="";
if(isset($_POST['username'])&&isset($_POST['password'])){
	$sql='SELECT nama_karyawan as nama , karyawan_id
	FROM  `karyawan` 
	WHERE username =  "'.$_POST['username'].'"
	AND PASSWORD =  "'.$_POST['password'].'"
	LIMIT 1';
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
  	$query = $stmt->fetch(PDO::FETCH_ASSOC);
  	$_SESSION['login'] = $query['nama'];
  	$_SESSION['karyawan']=$query['karyawan_id'];
  	$notice="Login Berhasil";
  	header('Location: http://localhost/tugas/index.php?notice='.$notice);
  	exit();
	}else{
		$notice ="Username atau password salah";
		header('Location: http://localhost/tugas/index.php?notice='.$notice);
		exit;
	}
}else{
	$notice ="data tidak lengkap";
	header('Location: http://localhost/tugas/index.php?notice='.$notice);
	exit;
}


?>