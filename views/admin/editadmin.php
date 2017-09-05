	<div class="container">
	<h5>Kayıt Tarihiniz : <?=$post->created_at?></h5>
	  <form method="POST">
	    <div class="form-group row">
	      <label for="inputEmail3" class="col-sm-2 col-form-label">Kullanıcı Adı</label><br>
	      <div class="col-sm-10">
	        <input type="text" class="form-control" id="inputEmail3" name="kadi" placeholder="Kullanıcı Adı" value="<?=$post->kadi?>">
	      </div>
	    </div>
	    <div class="form-group row">
	      <label for="inputPassword3" class="col-sm-2 col-form-label">Parola<br></label>
	      <div class="col-sm-10">
	        <input type="password" class="form-control" id="inputPassword3" name="parola" placeholder="Parola" value="<?=$post->kadi?>">
	      </div>
	    </div>
	    
	    <div class="form-group row">
	      <div class="col-sm-10">
	        <button type="submit" class="btn btn-primary">Güncelle</button>
	      </div>
	    </div>
	  </form>
	</div>
	<br><br>