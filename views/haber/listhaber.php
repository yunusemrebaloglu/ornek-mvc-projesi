<form class="form-inline " method="POST" >
	<div class="col-sm-4">
    <a href="?haber=list" class="btn btn-success"> Hepsini Göster </a>
	</div>
	<div class="col-sm-4"></div>
	<div class="input-group mb-0 mr-sm-0 mb-sm-0">
		<div class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></div>
		<input name="search" type="text" class="form-control" placeholder="Arama Yapın" value="<?=$searchvalue?>">
	</div>
	<button type="submit" class="btn btn-success">Ara</button>
</form>
<br><hr>

<div class="container">
		<?php foreach($haberler as $haberdetay): ?>
<div class="card card-inverse" style="background-color: #dce6f7; border-color: #dce6f7;">
  <div class="card-block">
    <div class="form-group row">
      <div class="col-sm-6">
        <h5><b><?=$haberdetay->title?></b></h5>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-2"><?=$haberdetay->created_at?></div>
    </div>
    <div class="form-group row">
      <div class="col-sm-11">
        <div class="card card-block bg-faded">
        	<p><?=kelimesiniri($haberdetay->detail)?></p>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2">
        <h6>  <?=$haberdetay->kadi?></h6>
      </div>
      <div class="col-sm-8"></div>
      <div class="col-sm-2">
      	<div class="btn-group" role="group" aria-label="Basic example">		  
      		<a href="?haber=birhaber&id=<?=$haberdetay->id?>" type="button" class="btn btn-secondary">Detay</a>
		</div>
      </div>
    </div>
  </div>
</div>
	<hr>
		<?php endforeach; ?>
    <?php if (isset($sayfa)):?>
        <div class="form-group row ">
    <div class="col-sm-5"></div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php if(isset($oncekisayfa)):?>
        <li class="page-item"><a class="page-link" href="?haber=list&sayfa=<?=$oncekisayfa?>">Önceki Sayfa</a></li>
        <li class="page-item"><a class="page-link" href="?haber=list&sayfa<?=$oncekisayfa?>"><?=$oncekisayfa?></a></li>
        <?php endif; ?>
        <li class="page-item"><a class="page-link" href="?haber=list&sayfa=<?=$sayfa?>"><?=$sayfa?></a></li>
        <?php if(isset($sonrakisayfa)):?>
        <li class="page-item"><a class="page-link" href="?haber=list&sayfa=<?=$sonrakisayfa?>"><?=$sonrakisayfa?></a></li>
        <li class="page-item"><a class="page-link" href="?haber=list&sayfa=<?=$sonrakisayfa?>">Sonraki Sayfa</a></li>
    <?php endif; ?>
      </ul>
    </nav>
    </div>
    <?php endif; ?>
</div>
<br>


	

