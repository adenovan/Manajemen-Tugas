<?php
session_start();
include 'lib-connection.php';
if(isset($_SESSION['login'])&& isset($_POST)){

	switch($_POST['submit']){
	case "Kerjakan":
	$status=1;
	$fix='<label class="label label-warning">Kerjakan</label>';
	$notice="Status Tugas : ".$_POST['namatugas']." berhasil di rubah menjadi di ".$fix."";
	$isi="di ".$fix;
	break;
	case "Selesaikan":
	$status=2;
	$fix='<label class="label label-success">Selesaikan</label>';
	$notice="Tugas : ".$_POST['namatugas']." sudah di ".$fix."";
	$isi="di ".$fix;
	break;
	}
	$sql="UPDATE `tugas` SET  `status` =  '".$status."' WHERE  `tugas`.`tugas_id` =".$_POST['tugas'].";";
	$stmt=$dbh->prepare($sql);
    $stmt->execute();

    $tugas = $_POST['tugas'];
    $namatugas= $_POST['namatugas'];
    $karyawan = $_SESSION['karyawan'];
    $karyawanid=$_POST['karyawanid'];
    $karyawanuntuk=$_POST['karyawanuntuk'];


    $namatugass='<span class="bold">'.$namatugas.'</span>';

    if($karyawan==$karyawanuntuk){
    //aksi dan 1 notif pada session ada dalam oleh atau untuk
    $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
    $sql="INSERT INTO `aksi` VALUES (null,'".$karyawan."','".$prepare."', 'Merubah status menjadi ".$isi." pada tugas ".$namatugass."', NOW(),0);";
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

        if($karyawan!==$karyawanid){
        $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
        $sql="INSERT INTO `notifikasi` VALUES (null, '".$karyawanid."', '".$karyawan."','".$prepare."', 'Status pada tugas ".$namatugass." berubah menjadi ".$isi."', NOW(),0);";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        }
    }

    if($status==2){
        $sql="UPDATE tugas SET tanggal_penyerahan = NOW() WHERE tugas_id = ".$tugas.";";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
    }

    header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
    exit;
}
else{
	$notice='Error:No Session found';
    header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
    exit;
}

?>