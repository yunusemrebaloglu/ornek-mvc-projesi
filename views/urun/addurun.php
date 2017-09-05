<div class="container">
  <form method="post" enctype="multipart/form-data" >
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Ürünün Fotoğrafını Yükleyiniz.</b></label><br>
      <div class="col-sm-9">
        <input type="file" name="photo" >
      </div>
      <div class="col-sm-1">
        <a href="<?=$_SERVER['HTTP_REFERER']?>" type="button" class="btn btn-danger">GERİ</a>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Tam Adını Giriniz</b></label><br>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="full_name" placeholder="Adı">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Detayını Giriniz.</b><br></label>
      <div class="col-sm-10">
        <textarea name="detail" cols="96%" rows="10" placeholder="Bilgileri"></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Fiyatını Giriniz.</b><br></label>
      <div class="col-sm-10">
        <input type="number" class="form-control" name="fiyat" placeholder="Fiyatı">
      </div>
    </div>    
    
    <div class="form-group row">
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Profili Kaydet</button>
      </div>
    </div>
  </form>
</div>