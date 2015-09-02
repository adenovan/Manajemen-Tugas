<?php 
session_start();
include 'lib-connection.php';
if(isset($_SESSION['login'])&& isset($_POST)){
    $karyawan = $_SESSION['karyawan'];
    $tugas = $_POST['tugas'];
    $namatugas= $_POST['namatugas'];
    $komentar =$_POST['komentar'];
    $karyawanid=$_POST['karyawanid'];
    $karyawanuntuk=$_POST['karyawanuntuk'];
    if(strlen(trim($komentar)) >= 4){
    $sql= "INSERT INTO komentar VALUES(null , '".$karyawan."' , '".$tugas."' , '".$komentar."' , NOW())";
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    $notice="<label class=\"label label-primary\">Komentar</label> ".$komentar." Berhasil di Posting";

    $komentars='<span class="italic">'.$komentar.'</span>';
    $namatugass='<span class="bold">'.$namatugas.'</span>';

    if($karyawan==$karyawanid||$karyawan==$karyawanuntuk){
    //aksi dan 1 notif pada session ada dalam oleh atau untuk
    $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
    $sql="INSERT INTO `aksi` VALUES (null,'".$karyawan."','".$prepare."', 'Memberi <label class=\"label label-primary\">komentar</label> ".$komentars." pada tugas ".$namatugass."', NOW(),0);";
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

        if($karyawan!==$karyawanid){
        $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
        $sql="INSERT INTO `notifikasi` VALUES (null, '".$karyawanid."', '".$karyawan."','".$prepare."', '<label class=\"label label-primary\">Komentar</label> ".$komentars." pada tugas ".$namatugass."', NOW(),0);";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        }
        if($karyawan!==$karyawanuntuk){
        $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
        $sql="INSERT INTO `notifikasi` VALUES (null, '".$karyawanuntuk."', '".$karyawan."','".$prepare."', '<label class=\"label label-primary\">Komentar</label> ".$komentars." pada tugas ".$namatugass."', NOW(),0);";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        }

    }
    else{
    //aksi dam 2 notif dari session tidak ada dalam oleh dan untuk 
    $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
    $sql="INSERT INTO `aksi` VALUES (null,'".$karyawan."','".$prepare."', 'Memberi <label class=\"label label-primary\">komentar</label> ".$komentars." pada tugas ".$namatugass."', NOW(),0);";
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    
        //notifikasi
        if($karyawanid == $karyawanuntuk)
        {
        $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
        $sql="INSERT INTO `notifikasi` VALUES (null, '".$karyawanid."', '".$karyawan."','".$prepare."', '<label class=\"label label-primary\">Komentar</label> ".$komentars." pada tugas ".$namatugass."', NOW(),0);";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        }
        else
        {
        $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
        $sql="INSERT INTO `notifikasi` VALUES (null, '".$karyawanid."', '".$karyawan."','".$prepare."', '<label class=\"label label-primary\">Komentar</label> ".$komentars." pada tugas ".$namatugass."', NOW(),0);";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();

        $prepare ='<a class="notif-modal" href="/backend/tugas.proses.php?tugas='.$tugas.'" data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
        $sql="INSERT INTO `notifikasi` VALUES (null, '".$karyawanuntuk."', '".$karyawan."','".$prepare."', '<label class=\"label label-primary\">Komentar</label> ".$komentars." pada tugas ".$namatugass."', NOW(),0);";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        }
    }
    header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
    exit;
    }else{
        $notice= "komentar terlalu pendek";
        header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
        exit;
    }
}else{
    $notice='No Session found';
    header('Location: http://manajemen-tugas.dev/index?notice='.$notice);
    exit;
}


?> 

