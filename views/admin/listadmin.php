<form class="form-inline " method="POST" >
	<label class="sr-only" for="inlineFormInputGroupUsername2">KULLANICI ADI</label>
    <a href="?admin=list" class="btn btn-primary"> Hepsini Göster </a>
	<div class="input-group mb-4 mr-sm-4 mb-sm-0">
		<div class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></div>
		<input name="search" type="text" class="form-control" placeholder="Arama Yapın" value="<?=$searchvalue?>">
	</div>
	<button type="submit" class="btn btn-primary">Ara</button>
</form>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>id</th>
			<th>Kullanıcı Adı</th>
			<th>Parolası</th>
			<th>Kayıt tarihi ve güncelleme tarihi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($adminler as $adminsirala): ?>
	<tr>
		<td><?=$adminsirala->id?></td>
		<td><?=$adminsirala->kadi?></td>
		<td><?=$adminsirala->parola?></td>
		<td><?=$adminsirala->created_at?></td>
		<td>
			<div class="btn-group" role="group">
				<a href="?admin=update&id=<?=$adminsirala->id?>" class="btn btn-primary">DÜZENLE</a>
				<a href="?admin=delete&id=<?=$adminsirala->id?>" class="btn btn-secondary" onclick="return confirm('Silmek istediğinize emin misiniz?');">SİL</a>
			</div>
		</td>
	</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	<?php if (isset($sayfa)):?>
    <div class="form-group row ">
    <div class="col-sm-5"></div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php if(isset($oncekisayfa)):?>
        <li class="page-item"><a class="page-link" href="?admin=list&sayfa=<?=$oncekisayfa?>">Önceki Sayfa</a></li>
        <li class="page-item"><a class="page-link" href="?admin=list&sayfa<?=$oncekisayfa?>"><?=$oncekisayfa?></a></li>
        <?php endif; ?>
        <li class="page-item"><a class="page-link" href="?admin=list&sayfa=<?=$sayfa?>"><?=$sayfa?></a></li>
        <?php if(isset($sonrakisayfa)):?>
        <li class="page-item"><a class="page-link" href="?admin=list&sayfa=<?=$sonrakisayfa?>"><?=$sonrakisayfa?></a></li>
        <li class="page-item"><a class="page-link" href="?admin=list&sayfa=<?=$sonrakisayfa?>">Sonraki Sayfa</a></li>
    <?php endif; ?>
      </ul>
    </nav>
    </div>
    <?php endif; ?>