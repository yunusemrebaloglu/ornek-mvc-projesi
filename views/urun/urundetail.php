<div class="container">
	<div class="card card-inverse" style="background-color: #dce6f7; border-color: #dce6f7;">
	  	<div class="card-block">
		    <div class="form-group row">
				<div class="col-sm-6">
			<img style="width:100%;height:100%;" src="img/foto/<?=$post->fotoname?>">
				</div>
				<div class="col-sm-6">
					<br>
					<h2><b>Ürünün Adı : <?=$post->full_name?></b></h2>
					<br>
					<h2><b>Ürünün Fiyatı : <?=$post->fiyat?> TL</b></h2>
					<div class="card card-block bg-faded">
				        	<p><?=$post->detail?></p>
				        </div>
				</div>
				<br>
				    <br><br>
				    <div class="col-sm-2"><br><br><a href="<?=$_SERVER['HTTP_REFERER']?>" type="button" class="btn btn-primary">GERİ</a></div>
				    	<div class="col-sm-8"></div>
				        <div class="col-sm-2">
				        <?=$post->created_at?><br><br>
				      <?php if ($_SESSION): ?>
				      	
				      	<div class="btn-group" role="group" aria-label="Basic example">		  
				      		<a href="?urun=update&id=<?=$post->id?>" type="button" class="btn btn-secondary">Düzenle</a>
				  		  	<a href="?urun=delete&id=<?=$post->id?>" type="button" class="btn btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
						</div>
						Yükleyenin Kullanıcı adı : <?=$post->kadi?>				
				      <?php endif; ?>
				      </div>
			</div>
		</div>		
	</div>
</div>


