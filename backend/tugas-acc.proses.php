<?php 
session_start();
include 'lib-connection.php';
$sql="SELECT a.tugas_id ,a.tags,DATE_FORMAT(a.tanggal_penugasan,'%d %b %Y %h:%i %p') as tanggal_penugasan, a.tugas , b.nama_karyawan as oleh , a.status 
FROM tugas as a
LEFT JOIN karyawan  as b on a.karyawan_id = b.karyawan_id
LEFT JOIN karyawan  as c on a.karyawan_untuk = c.karyawan_id";

//no status
if(isset($_SESSION['karyawan'])&&isset($_GET['tugas'])){
	$tugas_id = $_GET['tugas'];
	$sql.= " WHERE karyawan_untuk = ";
	$sql.=$_SESSION['karyawan'];
	if(isset($_GET['status'])){
	$sql.= " AND status = ".$_GET['status'];
	};
	$sql .=" ORDER BY a.tugas_id DESC";
	$sql .=" LIMIT ";
	$sql .=$tugas_id;
	$sql .=" , 5";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	//cek data
	if ($stmt->rowCount() > 0) {
  	$query = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}else{
		$query =array();
		echo '<div class="input-wrap">Anda tidak memiliki Tugas</div>';
		exit;
	}
	$html ="";
	$html.='<script>
        $("a[data-target=#myModal]").click(function(ev) {
        ev.preventDefault();
        var target = $(this).attr("href");
        // load the url and show modal on success
         $("#myModal .modal-dialog").load(target, function() { 
         $("#myModal").modal("show"); 
        });
        });
	</script>';
	foreach ($query as $result) {
	$html .='<a href="/backend/tugas.proses.php?tugas='.$result['tugas_id'].'"  data-target="#myModal" data-controls-modal="#myModal" data-backdrop="static" data-keyboard="false" >';
	$html .='<table class="table table-content">';
	$html .='<tr>';
	$html .='<td class="col-md-2"><span class="label label-info">'.$result['tags'].'</span></td>';
	$html .='<td class="col-md-6 col-judul">'.$result['tugas'].'</td>';
	$html .='<td rowspan="2" class="col-status col-md-1">';
	//switch status
	switch ($result['status']) {
		case 0:
			$html .='<span class="label label-danger label-status">TERBUKA';
			break;
		case 1:
			$html .='<span class="label label-warning label-status">DIKERJAKAN';
			break;
		case 2:
			$html .='<span class="label label-success label-status">SELESAI';
			break;
		default:
			$html .='<span class="label label-danger label-status">TERBUKA';
			break;
	}
	$html .='</span></td>';
	$html .='</tr>';
	$html .-'<tr>';
	$html .='<td>'.$result['tanggal_penugasan'].'</td>';
	$html .='<td>Oleh: '.$result['oleh'].'</td>';
	$html .='</tr></table></a>';
	}
	//send to frontend
	echo $html;
	exit;
}else{
   echo '<div class="input-wrap">ERROR 404</div>';
   exit;
}

?>