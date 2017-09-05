<div class="container">
    <div class="form-group row">
      <div class="col-sm-6">
        <h5><b><?=$post->title?></b></h5>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-2"><?=$post->created_at?></div>
    </div>
    <div class="form-group row">
      <div class="col-sm-12">
        <div class="card card-block bg-faded">
        	<p><?=$post->detail?></p>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2">
        <h6><b><?=$post->kadi?></b></h6>
      </div>
      <div class="col-sm-8"></div>
      <div class="col-sm-2">
      <?php if ($_SESSION): ?>
      	
      	<div class="btn-group" role="group" aria-label="Basic example">		  
      		<a href="?haber=update&id=<?=$post->id?>" type="button" class="btn btn-secondary">Düzenle</a>
  		  	<a href="?haber=delete&id=<?=$post->id?>" type="button" class="btn btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
      <?php endif ?>
		</div>
      </div>
    </div>
</div>
<br>