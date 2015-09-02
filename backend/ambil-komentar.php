<?php
session_start();
include 'lib-connection.php';
if(isset($_GET)){
$sql="SELECT a.tugas_id ,b.foto_karyawan, b.nama_karyawan , a.komentar , DATE_FORMAT(a.waktu,'%d %b %Y %h:%i %p') as waktu FROM komentar as a 
LEFT JOIN karyawan as b ON a.karyawan_id = b.karyawan_id
WHERE tugas_id=".$_GET['tugas']." ORDER BY a.komentar_id DESC LIMIT ".$_GET['offset'].",5";
$stmt=$dbh->prepare($sql);
$stmt->execute();

$html="";

	if ($stmt->rowCount() > 0) {
 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $value) {
 	$html.='<div class="komentar-content">
  	<div class="pull-left komentar-img"><img src="'.$value['foto_karyawan'].'" alt="" ></div> 
  	<div class="bold komentar-title">'.$value['nama_karyawan'].' <div class="komentar-waktu pull-right">'.$value['waktu'].'</div></div>
  	<div class="komentar-isi">'.$value['komentar'].'</div>
  	<div class="clearfix"></div>  
  	</div>';
  	$html.='<div class="clearfix"></div>';
	}
	echo $html;
	}
	else{
	$html.="Komentar Terakhir";
	echo $html;
	}
}
else{
	echo "no parameter";
}



?>