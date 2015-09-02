<?php
session_start();
include '../backend/lib-connection.php';
if(isset($_SESSION['karyawan'])){
$sql="SELECT karyawan_id, nama_karyawan, foto_karyawan
 FROM  `karyawan` WHERE karyawan_id = ".$_SESSION['karyawan']." LIMIT 1";
$stmt=$dbh->prepare($sql);
$stmt->execute();

$result=$stmt->fetch(PDO::FETCH_ASSOC);
$karyawan_id= $result['karyawan_id'];
$nama = $result['nama_karyawan'];
$foto = $result['foto_karyawan'];
}else{
	echo "ERROR: NO SESSION FOUND";
}

?>


<div class="input-wrap">
<h3>Pengaturan Akun</h3>

<div class="preview-box" style="margin-bottom:10px;"><h4>Preview</h4>
<h5 class="italic bold">Komentar</h5>
<div class="preview-foto"><img class="foto-komentar pfoto" src="<?php echo $foto;?>"> <span class="bold pnama" style="font-size:18px;"><?php echo $nama;?></span></div>
<h5 class="italic bold">Beranda</h5>
<div class="preview-foto"><img class="foto-index pfoto" src="<?php echo $foto;?>" > <span class="pnama"><?php echo $nama;?></span></div>
</div>

<h3>Rubah</h3>
<form class="form-horizontal preview-box" style="padding-top:10px;" role="form" action="/backend/edit-acc.proses.php" id="form-editacc" method="post" enctype="multipart/form-data">  
  <div class="form-group">
    <label class="control-label col-sm-3" for="editfoto">Foto:</label>
    <div class="col-sm-8">
    <span class="input-group inp-file">
      <span class="btn btn-primary btn-file">
      Browse&hellip; <input type="file" name="editfoto" id="editfoto">
      </span>
      <span id="fotoname"></span>
      </span>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="edit-nama">Nama:</label>
    <div class="col-sm-8">
    	<input type="text" placeholder="Rubah Nama" name="edit-nama" id="edit-nama" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="edit-password">Password:</label>
    <div class="col-sm-8">
    	<input type="password" placeholder="Rubah Password" name="edit-password" id="edit-password" class="form-control">
    </div>
  </div>
  

  <div class="form-group"> 
    <div class="col-sm-offset-3 col-sm-8">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>

</form>
</div>
<script>

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.pfoto').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#editfoto").change(function(){
    var ext = $('#editfoto').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
    $('#fotoname').html("ekstensi yang diperbolehkan jpg,png");
    $('#fotoname').addClass("danger");
    }else{
    readURL(this);
    var path = $('#editfoto').val();
    var filename = path.replace(/^.*\\/, "");
    $('#fotoname').html(filename);
    $('#fotoname').removeClass("danger");
    }
});

$("#edit-nama").keyup(function(){
  var data = $('#edit-nama').val();
  $('.pnama').html(data);
});
  
</script>