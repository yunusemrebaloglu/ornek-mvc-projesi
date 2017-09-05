<?php
require_once 'inc/init.php';

class FotoController {
	public static function add()
	{	
		// yetkiziyaret(); fonksiyonu ile sadece giriş yapmş adminlerin bu işlemleri yapması için bir fonksiyon oluşrueuldu. ve burada kendilerini tanıtmak için fotoğraf ve kişisel bilgileri eklemek için yapılan kısım.
		yetkiziyaret();
			if (isset($_FILES['photo'])) {
				if (isset($_POST)) {
					if(isset($_POST['full_name']) AND isset($_POST['detail'])){
						$foto =$_FILES['photo'];
						$yenifotoname = foto::fototrue($foto);
							$post = new foto;
							$post->kadi = $_SESSION['kadi'];
							$post->full_name = $_POST['full_name'];
							$post->fotoname = $yenifotoname->fotoname;
							$post->detail = $_POST['detail'];
							$post->save();
							if ($post) {
							header("Location: ?foto=fotokim&id=$post->id");
							}
					}
				}
			}
		 include'views/foto/addfoto.php';
	}
	public static function list()
	{	
		if (empty($_POST['search'])) {
		$kactane = 24;
		$kactan = 0;
		$fotolarcount = foto::fotolarcount();
		$sayfasayisi = ceil($fotolarcount/$kactane);
		$sayfa = 1 ;	
		if (isset($_GET['sayfa'])) {
			$sayfa = (int)$_GET['sayfa'];
			if ($sayfa ==1) {
				$kactane = 24;
				$kactan = 0;
			}elseif ($sayfa!=1) 
			{
				if ($sayfa > $sayfasayisi ) {
					header("Location: index.php");
				}
				$kactan = ($sayfa * $kactane) - ($kactane);
			}
		}
			if ($sayfa != $sayfasayisi) {
				$sonrakisayfa = $sayfa+1 ;
			}
			if ($sayfa != 1) {
				$oncekisayfa =$sayfa -1 ;
			}
		// fotoğrafları listelemek için yapılan kısım sorguda sayfalama yukarıdaki gibidir açıklaması admin controllerda vardır
        $fotolar = foto::all($orderBy = "LAST", $count = $kactane, $startFrom = $kactan );
		$searchvalue= null;
		}
		if (isset($_POST['search'])){
		$search=$_POST['search'];
		$searchvalue	= $search;	
		$fotolar   	=foto::search($search);
		}
		include "views/foto/listfoto.php";
	}
	public static function fotokim(){
		// sadece bir fotoğrafı gitmek için yapılan kısım
		$id = (int)$_GET['id'];
		if($id == 0 ) header("Location: index.php");
		$post = foto::find($id);
		if ($post) {
		include'views/foto/fotodetail.php';
		}else {
			header("Location: index.php");
		}
	}
	public static function delete()
	{		
		// fotoğrafı silmek için yapılan kısım
			yetkiziyaret();
			$id = (int)$_GET['id'];
			$fotobul = foto::find($id);
			$fotosilname = $fotobul->fotoname;
			$fotosil = foto::fotodelete($id, $fotosilname);
			header("Location: ?foto=list");


	}
	public static function update()
	{
		// fotoğrafı ve verileri güncellemek için yapılan kısım eğer fotoğraf gelmedi ise eski fotoğrafı kullansın eğer fotoğraf geldiyse eskiyi silip yeniyi yüklensin. 
		ob_start();  
		yetkiziyaret();
		$id = $_GET['id'];
		$post = foto::find($id);
		include'views/foto/editfoto.php';

				if (isset($_POST)) {
					if(isset($_POST['full_name']) AND isset($_POST['detail'])){
							if (isset($_FILES['photo'])){
										$deletefoto = $post->fotoname;
										$fotonameobjec = foto::fototrue($foto);
										$fotonameobj = $fotonameobjec->fotoname;
							if ($fotonameobj) {
										unlink("img/foto/$deletefoto");
										$foto =$_FILES['photo'];
							}
							}
							if(!$fotonameobj){
				 					$fotonameobj = $post->fotoname;
							}
							$post->kadi = $_SESSION['kadi'];
							$post->fotoname = $fotonameobj;
							$post->full_name = $_POST['full_name'];
							$post->detail = $_POST['detail'];
							$post->save();
							if ($post) { 	
							header("Location: ?foto=fotokim&id=$post->id");
							 
							}
					}
						
				}


	}
}