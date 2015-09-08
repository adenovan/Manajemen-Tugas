<?php
session_start();
include 'lib-connection.php';
$sql  ="SELECT dibaca FROM `notifikasi` WHERE karyawan_id = ".$_SESSION['karyawan']." and dibaca=0";
$stmt=$dbh->prepare($sql);
$stmt->execute();
echo $stmt->rowCount();
?>