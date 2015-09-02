<?php
session_start();
include 'lib-connection.php';
if(isset($_SESSION['login'])&& isset($_POST)){

$judul = $_POST['judul'];
$tags = $_POST['tags'];
$karyawan_id = $_SESSION['karyawan'];
$karyawan_untuk = $_POST['ditugaskan'];
$lokasi = $_POST['lokasi'];
$deskripsi= $_POST['deskripsi'];
$bataswaktu = $_POST['batas'];


$sql="INSERT INTO `tugas` 
VALUES (null,'".$judul."','".$tags."',".$karyawan_id.",".$karyawan_untuk.",'".$lokasi."',
NOW(),'".$bataswaktu."',null,0,'".$deskripsi."');SELECT LAST_INSERT_ID();";
$stmt=$dbh->prepare($sql);
$stmt->execute();
$lastid = $dbh->lastInsertId();
if($karyawan_id!==$karyawan_untuk){
	$prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$lastid.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
    $sql="INSERT INTO `notifikasi` VALUES (null, '".$karyawan_untuk."', '".$karyawan_id."','".$prepare."', '<label class=\"label label-primary\">Tugas</label> baru ".$judul." oleh ".$_SESSION['login']."', NOW(),0);";
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

    $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$lastid.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
    $sql="INSERT INTO `aksi` VALUES (null,'".$karyawan_id."','".$prepare."', 'Membuat <label class=\"label label-primary\">Tugas</label> baru ".$judul."', NOW(),0);";
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

}else{
	$prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$lastid.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
    $sql="INSERT INTO `aksi` VALUES (null,'".$karyawan_id."','".$prepare."', 'Membuat <label class=\"label label-primary\">Tugas</label> baru ".$judul."', NOW(),0);";
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
}

$notice="Tugas baru ".$judul."berhasil di buat";
    header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
 	exit;
}else{
	$notice="SESSION ERROR";
	header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
	exit;
}
?>