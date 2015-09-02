<?php
session_start();
include 'lib-connection.php';
include 'ImageManipulator.php';
$notice="<br/>";
if(isset($_POST['edit-nama'])){

	if(strlen($_POST['edit-nama']) > 3){
	$sql="UPDATE  `karyawan` SET  `nama_karyawan` =  
	'".$_POST['edit-nama']."' WHERE `karyawan_id` =  '".$_SESSION['karyawan']."'";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$notice.= "nama berhasil di rubah"."<br/>";
	$_SESSION['login'] = $_POST['edit-nama'];
	}else if(strlen($_POST['edit-nama']) > 0 && strlen($_POST['edit-nama']) < 4){
		$notice.="nama terlalu pendek min 4 karakter"."<br/>";
	}
}

if(isset($_POST['edit-password'])){
	if(strlen($_POST['edit-password']) > 3){
	$pass = md5($_POST['edit-password']);
	$sql="UPDATE  `karyawan` SET  `password` =  
	'".$pass."' WHERE `karyawan_id` =  '".$_SESSION['karyawan']."'";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$notice.= "password berhasil di rubah"."<br/>";
	}else if(strlen($_POST['edit-password']) > 0 && strlen($_POST['edit-password']) < 4){
		$notice.="password terlalu pendek min 4 karakter"."<br/>";
	}
}

if(isset($_FILES["editfoto"])){
	if(strlen($_FILES["editfoto"]["tmp_name"])>0 && $_FILES["editfoto"]["error"]==0){
	$tmp_name = $_FILES["editfoto"]["tmp_name"];
	$name = $_FILES["editfoto"]["name"];
	$ext = pathinfo($name, PATHINFO_EXTENSION);
	$name = uniqid().".".$ext;
	$im = new ImageManipulator($_FILES['editfoto']['tmp_name']);
	$im->resample(240, 320,false);
	switch ($ext) {
 	case 'jpg':
 	$im->save('../img/'.$name, IMAGETYPE_JPEG);
 	break;
 	case 'png':
	$im->save('../img/'.$name, IMAGETYPE_PNG);
 	break;
 	default:
 	$im->save('../img/'.$name, IMAGETYPE_JPEG);
 	break;
 	}	 

	$foto= "/img/".$name;
	$sql="UPDATE `karyawan` SET  `foto_karyawan` =  '".$foto."' WHERE `karyawan_id` =  '".$_SESSION['karyawan']."';";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$notice.= "foto berhasil di rubah"."<br/>";
	$_SESSION['foto']=$foto;
	}else{
		$notice.="Foto error tidak bisa di baca"."<br/>";
		exit;
	}
}

header('Location: http://manajemen-tugas.dev/index?notice='.$notice);

?>