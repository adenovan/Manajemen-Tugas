<?php
include 'lib-connection.php';
if(isset($_GET['q'])){
$sql="SELECT a.tags,  a.tugas, c.nama_karyawan AS untuk
FROM tugas AS a
LEFT JOIN karyawan AS c ON a.karyawan_untuk = c.karyawan_id
WHERE a.tugas LIKE  '%".$_GET['q']."%'";

	if(isset($_GET['cariuntuk'])){
	$sql.=" OR c.nama_karyawan LIKE '%".$_GET['q']."%'";
	}

	if(isset($_GET['caritags'])){
	$sql.=" OR a.tags LIKE '%".$_GET['q']."%'";
	}

	$sql.="	ORDER BY a.tugas_id DESC";

	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$halaman=ceil($stmt->rowCount()/5);
	
	echo $halaman;
	exit;
}
?>