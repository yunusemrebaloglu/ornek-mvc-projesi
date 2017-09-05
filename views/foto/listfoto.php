<form class="form-inline " method="POST" >
	<div class="col-sm-4">
    <a href="?foto=list" class="btn btn-success"> Hepsini Göster </a>
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
<div class="center">
<div class="card card-inverse" style="background-color: #dce6f7; border-color: #dce6f7;">
  <div class="card-block">
    <div class="form-group row">
    <?php foreach($fotolar as $fotodetay): ?>
      <div class="col-sm-3">
      <hr>
        <h5><b><?=$fotodetay->full_name?></b></h5>
      <img style="width:128px;height:128px;" src="img/foto/<?=$fotodetay->fotoname?>">
      <br>
      <a href="?foto=fotokim&id=<?=$fotodetay->id?>" class="btn btn-primary">Detay</a>
    </div>
    <?php endforeach; ?>
      </div>
</div>
  </div>
</div>
    <?php if (isset($sayfa)):?>
    <div class="form-group row ">
    <div class="col-sm-5"></div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php if(isset($oncekisayfa)):?>
        <li class="page-item"><a class="page-link" href="?foto=list&sayfa=<?=$oncekisayfa?>">Önceki Sayfa</a></li>
        <li class="page-item"><a class="page-link" href="?foto=list&sayfa<?=$oncekisayfa?>"><?=$oncekisayfa?></a></li>
        <?php endif; ?>
        <li class="page-item"><a class="page-link" href="?foto=list&sayfa=<?=$sayfa?>"><?=$sayfa?></a></li>
        <?php if(isset($sonrakisayfa)):?>
        <li class="page-item"><a class="page-link" href="?foto=list&sayfa=<?=$sonrakisayfa?>"><?=$sonrakisayfa?></a></li>
        <li class="page-item"><a class="page-link" href="?foto=list&sayfa=<?=$sonrakisayfa?>">Sonraki Sayfa</a></li>
    <?php endif; ?>
      </ul>
    </nav>
    </div>
    <?php endif; ?>
</div>
<br>


	

