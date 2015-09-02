<?php
include '../backend/lib-connection.php';

$option ="";

$sql="SELECT karyawan_id , nama_karyawan as nama FROM karyawan";
$stmt=$dbh->prepare($sql);
$stmt->execute();

$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $value) {
  $option.='<option value="'.$value['karyawan_id'].'">'.$value['nama'].'</option>';
}
?>
<script type="text/javascript" src="/js/jqueryvalidation/additional-methods.min.js" charset="UTF-8"></script>
<div class="input-wrap">
<form class="form-horizontal" role="form" action="/backend/plus.proses.php" id="form-plus" method="post">
  <div class="form-group">
    <label class="control-label col-sm-3" for="judul">Judul:</label>
    <div class="col-sm-8">
    	<input type="text" placeholder="Judul Tugas" name="judul" id="judul" class="form-control" required>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="ditugaskan">Untuk:</label>
    <div class="col-sm-8"> 
    <select name="ditugaskan" id="ditugaskan" class="form-control">
    <?php echo $option ?>
		</select>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="tags-input">Tautan:</label>
    <div class="col-sm-8">
      <input type="text" placeholder="Tautan Tugas" name="tags" id="tags-input" class="form-control" required>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="lokasi">Lokasi:</label>
    <div class="col-sm-8">
    	<input type="text" placeholder="Lokasi Tugas" name="lokasi" id="lokasi" class="form-control" required>
    </div>
  </div>
  
  <div class="form-group inp-dtp">
  <label for="dtp_input1" class="col-sm-3 control-label">Batas Waktu:</label>
  <div class="col-sm-8">
  <div class="input-group date form_datetime" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
  <input class="form-control" size="16" type="text" value="" readonly required>
  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
  <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
  </div>  
  <input type="hidden" id="dtp_input1" name="batas" value="" /><br/>
  </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="deskripsi">Deskripsi:</label>
    <div class="col-sm-8">
    	<textarea type="text" name="deskripsi" id="deskripsi" class="form-control"></textarea>
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-3 col-sm-8">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>

</form>
</div>

<script type="text/javascript">

    $('.form_datetime').datetimepicker({
    language:  'id',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
        showMeridian: 1
    });
  $('.form_date').datetimepicker({
    language:  'id',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
    });
  $('.form_time').datetimepicker({
    language:  'id',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
    });

  $("#form-plus").validate();
</script>