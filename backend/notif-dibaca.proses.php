<?php
include 'lib-connection.php';
$sql="UPDATE `notifikasi` SET `dibaca`=1 WHERE `notif_id`=".$_GET['notif']."";
$stmt=$dbh->prepare($sql);
$stmt->execute();
?>