<div class="input-wrap">
<form class="form-horizontal" role="form" action="/backend/plus.proses.php" id="form-plus">
  <div class="form-group">
    <label class="control-label col-sm-3" for="judul">Judul:</label>
    <div class="col-sm-8">
    	<input type="text" placeholder="Judul Tugas" name="judul" id="judul" class="form-control">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="ditugaskan">Untuk:</label>
    <div class="col-sm-8"> 
      	<select name="ditugaskan" id="ditugaskan" class="form-control">
		<option value="Riza">Riza</option>
		<option value="Yohanes">Yohanes</option>
		<option value="Anggi">Anggi</option>
		</select>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="lokasi">Lokasi:</label>
    <div class="col-sm-8">
    	<input type="text" placeholder="Lokasi Tugas" name="lokasi" id="lokasi" class="form-control">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="batas">Batas-Waktu:</label>
    <div class="col-sm-8">
    	<input type="datetime-local" name="batas" id="batas" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="deskripsi">Deskripsi:</label>
    <div class="col-sm-8">
    	<textarea type="date" name="deskripsi" id="deskripsi" class="form-control"></textarea>
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-3 col-sm-8">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>

</form>
</div>