<?php
include 'lib-connection.php';
if(isset($_GET['q'])){
$sql="SELECT a.tugas_id, a.tags, DATE_FORMAT(a.tanggal_penugasan,'%d %b %Y %h:%i %p') as tanggal_penugasan, a.tugas, b.nama_karyawan AS oleh, a.status , c.nama_karyawan AS untuk
FROM tugas AS a
LEFT JOIN karyawan AS b ON a.karyawan_id = b.karyawan_id
LEFT JOIN karyawan AS c ON a.karyawan_untuk = c.karyawan_id
WHERE a.tugas LIKE  '%".$_GET['q']."%'";

	if(isset($_GET['cariuntuk'])){
	$sql.=" OR c.nama_karyawan LIKE '%".$_GET['q']."%'";
	}

	if(isset($_GET['caritags'])){
	$sql.=" OR a.tags LIKE '%".$_GET['q']."%'";
	}
	
	if(isset($_GET['offset'])){
	$sql.="	ORDER BY a.tugas_id DESC LIMIT ";
	$sql.=$_GET['offset'];
	$sql.=" , 5";
	}

	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
  	$query = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}else{
		$query =array();
		echo '<div class="input-wrap">Tugas dengan hasil pencarian ini tidak ditemukan</div>';
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
	$html .='<td class="col-md-5 col-judul">'.$result['tugas'].'</td>';
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
	echo '<div class="input-wrap">Searching...</div>';
}

?>