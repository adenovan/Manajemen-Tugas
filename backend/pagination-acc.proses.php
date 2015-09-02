<?php 
	session_start();
	include 'lib-connection.php';
	$sql="SELECT tugas_id, status FROM tugas ";
	if(isset($_SESSION['karyawan'])){
		$sql.=" WHERE karyawan_untuk = ".$_SESSION['karyawan'];
	}
	if(isset($_GET['status'])){
	$sql.= " AND status = ".$_GET['status'];
	}
	$sql .=" ORDER BY tugas_id DESC";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$halaman=ceil($stmt->rowCount()/5);
	
	echo $halaman;
?>