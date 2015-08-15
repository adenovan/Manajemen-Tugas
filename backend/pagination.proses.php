<?php 
	include 'lib-connection.php';
	$sql="SELECT tugas_id, status FROM tugas ";
	if(isset($_GET['status'])){
		$sql.=" WHERE status = ".$_GET['status'];
	}
	$sql .=" ORDER BY tugas_id DESC";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$halaman=ceil($stmt->rowCount()/5);
	
	echo $halaman;
?>