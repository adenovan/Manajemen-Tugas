<?php
session_start();

include 'lib-connection.php';
if(isset($_GET['tugas'])){
 $sql ="SELECT a.tugas_id, a.tugas ,a.tags, b.nama_karyawan AS oleh, c.nama_karyawan AS untuk ,
  a.lokasi , a.status ,DATE_FORMAT(a.tanggal_penugasan,'%d %b %Y %h:%i %p') as tanggal_penugasan ,
  DATE_FORMAT(a.batas_waktu,'%d %b %Y %h:%i %p') as batas_waktu , 
  DATE_FORMAT(a.tanggal_penyerahan,'%d %b %Y %h:%i %p') as tanggal_penyerahan ,
  a.deskripsi_tugas ,a.karyawan_id , a.karyawan_untuk
 FROM tugas AS a
 LEFT JOIN karyawan AS b ON a.karyawan_id = b.karyawan_id
 LEFT JOIN karyawan AS c ON a.karyawan_untuk = c.karyawan_id
 WHERE a.tugas_id = ".$_GET['tugas']." LIMIT 1";
 $stmt=$dbh->prepare($sql);
 $stmt->execute();
  //cek data
 if ($stmt->rowCount() > 0) {
   $result = $stmt->fetch(PDO::FETCH_ASSOC);
 }else{
   $query =array();
   echo '<div class="input-wrap">Tugas tidak ditemukan</div>';
   exit;
 }

 $html ='<div class="modal-content">';
 $html.='<div class="modal-header">';
 $html.='<button type="button" class="close" data-dismiss="modal">Close &times;</button>';
 $html.='<h3 class="modal-title mod-judul">'.ucfirst($result['tugas'])." ";
   switch ($result['status']) {
    case 0:
      $html .='<span class="label label-danger label-status">TERBUKA';
      $action='<input type="submit" class="btn btn-warning btn-sm btn-act" value="Kerjakan" name="submit">';
      break;
    case 1:
      $html .='<span class="label label-warning label-status">DIKERJAKAN';
      $action='<input type="submit" class="btn btn-success btn-sm btn" value="Selesaikan" name="submit">';
      break;
    case 2:
      $html .='<span class="label label-success label-status">SELESAI';
      $action='';
      break;
    default:
      $html .='<span class="label label-danger label-status">TERBUKA';
      $action='';
      break;
  }
 $html.='</span>';
 $html.='</h3>';
 $html.='<span class="label label-info">'.$result['tags'].'</span>';
 $html.=' <span class="bold">Oleh:</span> '.$result['oleh'].' , ';
 $html.=' <span class="bold">Untuk:</span> '.$result['untuk']; 
 $html.='</div>';
 $html.='<div class="modal-body">';
 $html .='<table>
  <tr>
    <th class="col-md-2">Tanggal Penugasan</th>
    <th class="col-md-2">Batas Waktu</th>
    <th class="col-md-2">Tanggal Penyerahan</th>
  </tr>
  <tr>
    <td class="col-md-2">'.$result['tanggal_penugasan'].'</td>
    <td class="col-md-2">'.$result['batas_waktu'].'</td>
    <td class="col-md-2">'.$result['tanggal_penyerahan'].'</td>
  </tr>
  <tr>
  <td class="col-md-3">';
$html.='<span class="label label-default label-lokasi">Lokasi</span> '.ucfirst($result['lokasi']).' ';
$html.='</td>';

if(isset($_SESSION['karyawan']) && $_SESSION['karyawan']==$result['karyawan_untuk']){
$html.='<td class="col-md-3 col-md-offset-2">';
$html.='<form action="/backend/update-status.php" method="post">';
$html.='<input type="hidden" name="namatugas" value="'.ucfirst($result['tugas']).'">';
$html.='<input type="hidden" name="tugas" value="'.$_GET['tugas'].'">';
$html.='<input type="hidden" name="karyawanid" value="'.$result['karyawan_id'].'">';
$html.='<input type="hidden" name="karyawanuntuk" value="'.$result['karyawan_untuk'].'">';
$html.=$action;
$html.='</form>';
$html.='</td>';
}
$html.='</tr></table>';
 $html.='</div>';
 $html.='<div class="modal-footer" style="text-align:left;">';
 $html.='<div class="bold">Rincian Tugas</div>';
 $html.='<div class="deskripsi-tugas">'.$result['deskripsi_tugas'].'</div>';
 $sql="SELECT a.tugas_id ,b.foto_karyawan, b.nama_karyawan , a.komentar , DATE_FORMAT(a.waktu,'%d %b %Y %h:%i %p') as waktu FROM komentar as a 
 LEFT JOIN karyawan as b ON a.karyawan_id = b.karyawan_id
 WHERE tugas_id=".$_GET['tugas']." ORDER BY a.komentar_id DESC LIMIT 0,5";
 $stmt=$dbh->prepare($sql);
 $stmt->execute();
 $html.='<div class="komentar mod-komentar col-content">
 <h4 class="bold" style="color:#ffffff;">Komentar</h4>';
 if(isset($_SESSION['login'])){
 $html.='<form action="/backend/update-komentar.php" method="post" id="form-komentar">';
 $html.='<input type="hidden" name="namatugas" value="'.ucfirst($result['tugas']).'">';
 $html.='<input type="hidden" name="karyawanid" value="'.$result['karyawan_id'].'">';
 $html.='<input type="hidden" name="karyawanuntuk" value="'.$result['karyawan_untuk'].'">';
 $html.='<table lass="table table-komentar"><tr><td class="col-md-11" style="padding-left:0;">
 <input type="hidden" name="tugas" value="'.$_GET['tugas'].'"><textarea class="text-komentar" name="komentar" placeholder="Masukkan Komentar"></textarea></td>
 <td class="col-md-1"><input type="submit" id="button-submit-komentar" class="btn btn-success" value="kirim"></td></tr></table></form>';
 }
 $html.='<div id="komentar-wrapper">';
  if ($stmt->rowCount() > 0) {
  $result = $stmt->fetchAll();
  foreach ($result as $value) {
  $html.='<div class="komentar-content">
  <div class="pull-left komentar-img"><img src="'.$value['foto_karyawan'].'" alt="" ></div> 
  <div class="bold komentar-title">'.$value['nama_karyawan'].' <div class="komentar-waktu pull-right">'.$value['waktu'].'</div></div>
  <div class="komentar-isi">'.$value['komentar'].'</div>
  <div class="clearfix"></div>  
  </div>';
  $html.='<div class="clearfix"></div>';
   }
 }
 $html.='</div>';
 $sql="SELECT a.tugas_id FROM komentar as a  WHERE tugas_id=".$_GET['tugas'];
 $stmt=$dbh->prepare($sql);
 $stmt->execute();
 $html.='<div id="komentar-off" class="komentar-load" data-offset="0" data-max="'.$stmt->rowCount().'" data-tugas="'.$_GET['tugas'].'"><a href="/backend/ambil-komentar.php" id="prev"><i class="glyphicon glyphicon-triangle-left"></i>Prev</a>';
 $html.='  <a href="/backend/ambil-komentar.php" id="next">Next<i class="glyphicon glyphicon-triangle-right"></i></a>';
 $html.='<span id="komentar-text" style="color:#ffffff;font-style:italic;"> Komentar ke 1-5 </span>';
 $html.='</div>';
 $html.='</div>';
 $html.='</div>';
 $html.='</div>';
 echo $html;
}else{
  echo 'Tugas tidak ditemukan';
}
?>
<script type="text/javascript">
  $("#prev").click(function(e) {
  e.preventDefault();
  var off = $("#komentar-off").data("offset");
  var tugas=$("#komentar-off").data("tugas");
    if((off-5)<0){
    $("#komentar-text").html("Ini Halaman Komentar Awal");
    }else{
    off-=5;
    $("#komentar-off").data("offset" , off);
    $.get( "/backend/ambil-komentar.php", {tugas:tugas,offset:off} ).done(function( data ) {
    $("#komentar-wrapper").html("");
    $("#komentar-wrapper").html(data);
    $("#komentar-text").html("Komentar Ke " + (off+1) + "-" + (off+5));
    });
    }
  });

  $("#next").click(function(e) {
  e.preventDefault();
  var off = $("#komentar-off").data("offset");
  var max = $("#komentar-off").data("max");
  var tugas=$("#komentar-off").data("tugas");
    if((off+5) > max){
    $("#komentar-text").html("Ini Halaman Komentar Akhir")
    }
    else{
    off+=5;
    $("#komentar-off").data("offset" , off);
    $.get( "/backend/ambil-komentar.php", {tugas:tugas,offset:off} ).done(function( data ) {
    $("#komentar-wrapper").html("");
    $("#komentar-wrapper").html(data);
    $("#komentar-text").html("Komentar Ke " + (off+1) + "-" + (off+5));
    });
    }
  });

</script>




    








