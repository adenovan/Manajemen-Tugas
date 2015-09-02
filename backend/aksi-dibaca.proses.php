<?php
include 'lib-connection.php';
$sql="UPDATE `aksi` SET `dibaca`=1 WHERE `aksi_id`=".$_GET['aksi']."";
$stmt=$dbh->prepare($sql);
$stmt->execute();
?>