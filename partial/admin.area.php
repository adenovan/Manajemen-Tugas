<?php
session_start();
include '../backend/lib-connection.php';
if(isset($_SESSION['karyawan'])){
  $html="";
  $hapus="";
  if ($_SESSION['karyawan']==2) {
  $sql ="SELECT a.aksi_id, b.foto_karyawan, a.link, a.isi, 
  DATE_FORMAT(a.waktu,'%d %b %Y %h:%i %p') as waktu, a.dibaca
  FROM `aksi` AS a
  LEFT JOIN karyawan AS b ON a.karyawan_id = b.karyawan_id
   ORDER BY a.aksi_id DESC";
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
    $html.='<tr>
    <td class="col-sm-1"><img src="'.$result['foto_karyawan'].'" class="notif-foto" alt=""></td>
    <td class="col-sm-2">'.$result['waktu'].' <i class="glyphicon glyphicon-info-sign danger"></i></td>';
    }else{
    $html.='<table class="table table-content-notif notif" id="cont-notif" data-idnotif="'.$result['aksi_id'].'" data-dibaca="'.$result['dibaca'].'">';
    $html.='<tr>
    <td class="col-sm-1"><img src="'.$result['foto_karyawan'].'" class="notif-foto" alt=""></td>
    <td class="col-sm-2">'.$result['waktu'].' <i class="glyphicon glyphicon-ok-sign"></i></td>';
    }
    $html.='<td class="col-sm-9">'.$result['isi'].'</td>';
    $html.='</tr>';
    $html.='</table>';
    $html.='</a>';
    $html.='</div>';
    }
    $html.='</div>';
    }
    else{
    $html= "<div class=\"italic\" style=\"padding:10px;\">Anda tidak memiliki aktivitas</div>";
    };
  //delete query
  $sql ="SELECT karyawan_id, nama_karyawan FROM  `karyawan` where karyawan_id !=2";
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $query = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($stmt->rowCount() > 0) {
    foreach ($query as $result) {
    $hapus.='<div class="hapus-wrap col-sm-12">';
    $hapus.='<div class="col-sm-8">'.$result['nama_karyawan'].'</div>';
    $hapus.='<div class="col-sm-4">';
    $hapus.='<a href="/backend/hapus-karyawan.proses.php?id='.$result['karyawan_id'].'"><i class="glyphicon glyphicon-remove"></i> Hapus</a>';
    $hapus.='</div>';
    $hapus.='</div>';
    }
  }else{
    $hapus.="Tidak ada karyawan";
  }
  }
  else
  {
    echo "YOURE NOT SUPER USER !!";
    exit;
  }
}else{
	echo "ERROR: NO SESSION FOUND";
  exit;
}

?>


<div class="input-wrap col-sm-12">
<h3><i class="glyphicon glyphicon-user"></i> Admin Area</h3>
  <div class="navigasi-admin">
    <button class="btn btn-primary" id="admin-plus"><i class="glyphicon glyphicon-plus"></i> Karyawan</button>
    <button class="btn btn-default" id="admin-minus"><i class="glyphicon glyphicon-remove"></i> Karyawan</button> 
    <button class="btn btn-default" id="admin-aksi"><i class="glyphicon glyphicon-king"></i> Semua Aktivitas</button>  
  </div>

<div class="col-minus">
<h4 class="italic"><i class="glyphicon glyphicon-remove"></i> Hapus Karyawan</h4>
<div class="minus-box col-sm-12">
  <?php echo $hapus;?>
</div>
</div>

<div class="col-plus">
<h4 class="italic"><i class="glyphicon glyphicon-plus"></i> Tambah Karyawan</h4>
<form class="form-horizontal preview-box" style="padding-top:10px;" role="form" action="/backend/plus-karyawan.proses.php" 
id="form-admin" method="post">
  <div class="form-group">
    <label class="control-label col-sm-3" for="tambah-user">Username:</label>
    <div class="col-sm-8">
      <input type="text" placeholder="Username karyawan" name="tambah-user" id="tambah-user" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="tambah-password">Password:</label>
    <div class="col-sm-8">
      <input type="password" placeholder="Nama Password" name="tambah-password" id="tambah-password" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="tambah-nama">Nama:</label>
    <div class="col-sm-8">
    	<input type="text" placeholder="Nama Karyawan" name="tambah-nama" id="tambah-nama" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="tambah-jabatan">Jabatan:</label>
    <div class="col-sm-8">
      <input type="text" placeholder="Jabatan Karyawan" name="tambah-jabatan" id="tambah-jabatan" class="form-control">
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-3 col-sm-8">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>

</form>
</div>

<div class="col-aksi">
  <h4><i class="glyphicon glyphicon-king"></i> Semua Aktivitas</h4>
  <div class="aktivitas-box" style="margin-bottom:10px;">
  <?php echo $html;?>
  </div>
</div>

</div>

<script>
  $(".col-aksi").hide();
  $(".col-minus").hide();

  $(".notif-modal").click(function(ev) {
  ev.preventDefault();
  var target = $(this).attr("href");
  var x = $(this).find('.notif').data('idnotif');
  $("#myModal .modal-dialog").load(target, function() { 
    $("#myModal").modal("show");
    });
  });

  $("#admin-plus").click(function(event) {
    $(".col-aksi").hide();
    $(".col-minus").hide();
    $(".col-plus").show();
    $(this).removeClass('btn-default');
    $(this).addClass('btn-primary');
    $("#admin-minus").removeClass('btn-primary');
    $("#admin-minus").addClass('btn-default');
    $("#admin-aksi").removeClass('btn-primary');
    $("#admin-aksi").addClass('btn-default');
  });

  $("#admin-minus").click(function(event) {
    $(".col-aksi").hide();
    $(".col-minus").show();
    $(".col-plus").hide();
    $(this).removeClass('btn-default');
    $(this).addClass('btn-primary');
    $("#admin-plus").removeClass('btn-primary');
    $("#admin-plus").addClass('btn-default');
    $("#admin-aksi").removeClass('btn-primary');
    $("#admin-aksi").addClass('btn-default');
  });

  $("#admin-aksi").click(function(event) {
    $(".col-aksi").show();
    $(".col-minus").hide();
    $(".col-plus").hide();
    $(this).addClass('btn-primary');
    $("#admin-plus").removeClass('btn-primary');
    $("#admin-plus").addClass('btn-default');
    $("#admin-minus").removeClass('btn-primary');
    $("#admin-minus").addClass('btn-default');
  });


</script>

