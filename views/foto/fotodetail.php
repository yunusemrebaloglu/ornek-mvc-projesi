<div class="container">
	<div class="card card-inverse" style="background-color: #dce6f7; border-color: #dce6f7;">
	  	<div class="card-block">
		    <div class="form-group row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
			<img style="width:100%;height:100%;" src="img/foto/<?=$post->fotoname?>">
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-1"> <a href="<?=$_SERVER['HTTP_REFERER']?>" type="button" class="btn btn-danger">GERİ</a></div>
				<br>

					<div class="col-sm-3 center">
					Adı Soyadı: <?=$post->full_name?></div>
					<div class="col-sm-5"></div>
					<div class="col-sm-3 center">Kullanıcı adı : <?=$post->kadi?></div>
				    <div class="col-sm-12">
				        <div class="card card-block bg-faded">
				        	<p><?=$post->detail?></p>
				        </div>
				    </div>
				    <div class="col-sm-2"><?=$post->created_at?></div>
				    	<div class="col-sm-8"></div>
				        <div class="col-sm-2">
				      <?php if ($_SESSION): ?>
				      	
				      	<div class="btn-group" role="group" aria-label="Basic example">		  
				      		<a href="?foto=update&id=<?=$post->id?>" type="button" class="btn btn-secondary">Düzenle</a>
				  		  	<a href="?foto=delete&id=<?=$post->id?>" type="button" class="btn btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
						</div>				
				      <?php endif; ?>
				      </div>
			</div>
		</div>		
	</div>
</div>


