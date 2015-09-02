<?php   
session_start();
include 'lib-connection.php';
$sql ="SELECT a.aksi_id, b.foto_karyawan, a.link, a.isi, 
DATE_FORMAT(a.waktu,'%d %b %Y %h:%i %p') as waktu, a.dibaca
FROM `aksi` AS a
LEFT JOIN karyawan AS b ON a.karyawan_id = b.karyawan_id
WHERE a.karyawan_id=".$_SESSION['karyawan']."  ORDER BY a.aksi_id DESC";
$stmt=$dbh->prepare($sql);
$stmt->execute();
$query = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($stmt->rowCount() > 0) {
$html='<div class="notif-container">';
foreach ($query as $result) {
$html.='<div class="notif-content-wrap">';
$html.=$result['link'];
if($result['dibaca']==0){
$html.='<table class="table table-content notif" id="cont-notif" data-idnotif="'.$result['aksi_id'].'" data-dibaca="'.$result['dibaca'].'">';
$html.='<tr class="komentar-border">
<td><img src="'.$result['foto_karyawan'].'" class="notif-foto" alt=""></td>
<td class="komentar-notif">'.$result['waktu'].' <i class="glyphicon glyphicon-info-sign"></i></td></tr>';
}else{
$html.='<table class="table table-content-notif notif" id="cont-notif" data-idnotif="'.$result['aksi_id'].'" data-dibaca="'.$result['dibaca'].'">';
$html.='<tr class="komentar-border">
<td><img src="'.$result['foto_karyawan'].'" class="notif-foto" alt=""></td>
<td class="komentar-notif">'.$result['waktu'].' <i class="glyphicon glyphicon-ok-sign"></i></td></tr>';
}

$html.='<tr>';
$html.='<td colspan="2">'.$result['isi'].'</td>';
$html.-'</tr>';
$html.='</table>';
$html.='</a>';
$html.='</div>';
}
$html.='</div>';
echo $html;
}
else{
echo "<div class=\"italic\" style=\"padding:10px;\">Anda tidak memiliki aktivitas</div>";
};
?>
