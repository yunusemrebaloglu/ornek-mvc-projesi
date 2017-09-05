<div class="container">
  <form method="post" enctype="multipart/form-data" >
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Fotoğrafınızı Yükleyiniz.</b></label><br>
      <div class="col-sm-6">
        <input type="file" name="photo" value="/opt/lampp/htdocs/demo/img/foto/<?=$post->fotoname?>" >
      </div>
      <div class="col-sm-3">
          <img style="width:100%;height:100%;" src="img/foto/<?=$post->fotoname?>">
      </div>
      <div class="col-sm-1"><a href="<?=$_SERVER['HTTP_REFERER']?>" type="button" class="btn btn-danger">GERİ</a></div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Tam Adınızı Giriniz</b></label><br>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="full_name" placeholder="Adınız" value="<?=$post->full_name?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Kendi Detayını Giriniz.</b><br></label>
      <div class="col-sm-10">
        <textarea name="detail" cols="96%" rows="10" placeholder="Bilgileriniz"><?=$post->detail?></textarea>
      </div>
    </div>
    
    <div class="form-group row">
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Profili Kaydet</button>
      </div>
    </div>
  </form>
</div>
<br>