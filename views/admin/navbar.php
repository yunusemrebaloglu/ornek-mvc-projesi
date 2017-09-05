    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
         <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Ekleme İşlemleri
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="?urun=add">Ürün Ekle</a>
              <a class="dropdown-item" href="?haber=add">Haber Ekle</a>
              <a class="dropdown-item" href="?foto=add">Fotoğraf Ekle</a>
            </div>
          </li>
          <?php if ($_SESSION['admin_seviye']== 1 ):?>
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Üst Düzey Admin İşlemleri
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="?admin=add">Admin Ekle</a>
              <a class="dropdown-item" href="?admin=list">Adminleri Göster</a>
            </div>
          </li>
         <?php endif; ?>
         </ul>
        <form class="form-inline my-2 my-lg-0">
          <a class="navbar-brand" style="color: white;">Hoş Geldiniz Sayın ; <?=$_SESSION['kadi']?></a>
          <a class="navbar-brand" href="?admin=logout">Çıkış Yap</a>
        </form>
      </div>
    </nav>