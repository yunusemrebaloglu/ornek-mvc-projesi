<?php
require_once 'inc/init.php';

class UrunController{
	public static function add()
	{	
		yetkiziyaret();
			if (isset($_FILES['photo'])) {
				if (isset($_POST)) {
					if(isset($_POST['full_name']) AND isset($_POST['detail'])){
						$foto =$_FILES['photo'];
						$yenifotoname = urun::fototrue($foto);
							$post = new urun;
							$post->kadi = $_SESSION['kadi'];
							$post->full_name = $_POST['full_name'];
							$post->fiyat = $_POST['fiyat'];
							$post->fotoname = $yenifotoname->fotoname;
							$post->detail = $_POST['detail'];
							$post->save();
							if ($post) {
							header("Location: ?urun=urunne&id=$post->id");
							}
					}
				}
			}
		 include'views/urun/addurun.php';
	}
	public static function list()
	{	
		if (empty($_POST['search'])) {
		$kactane = 24;
		$kactan = 0;
		$urunlercount = urun::urunlercount();
		$sayfasayisi = ceil($urunlercount/$kactane);
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

// listelemek için yapılan kısım sorguda sayfalama yukarıdaki gibidir açıklaması admin controllerda vardır.
        $urunler = urun::all($orderBy = "LAST", $count = $kactane, $startFrom = $kactan );
		$searchvalue= null;
	}
		if (isset($_POST['search'])){
		$search=$_POST['search'];
		$searchvalue	= $search;	
		$urunler   	=urun::search($search);
		}
		include "views/urun/listurun.php";
	}
	public static function urunne(){
		$id = (int)$_GET['id'];
		if($id == 0 ) header("Location: index.php");
		$post = urun::find($id);
		if ($post) {
		include'views/urun/urundetail.php';
		}else {
			header("Location: index.php");
		}
	}
	public static function delete()
	{		
			yetkiziyaret();
			$id = (int)$_GET['id'];
			$fotobul = urun::find($id);
			$fotosilname = $fotobul->fotoname;
			$fotosil = urun::urundelete($id, $fotosilname);
			header("Location: ?urun=list");


	}
	public static function update()
	{	ob_start();  
		yetkiziyaret();
		$id = $_GET['id'];
		$post = urun::find($id);
		include'views/urun/editurun.php';

				if (isset($_POST)) {
					if(isset($_POST['full_name']) AND isset($_POST['detail']) AND isset($_POST['fiyat'])){
							if (isset($_FILES['photo'])){
										$deletefoto = $post->fotoname;
										$fotonameobjec = urun::fototrue($foto);
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
							$post->fiyat = $_POST['fiyat'];
							$post->fotoname = $fotonameobj;
							$post->full_name = $_POST['full_name'];
							$post->detail = $_POST['detail'];
							$post->save();
							if ($post) { 	
							header("Location: ?urun=urunne&id=$post->id");
							
							}
					}
						
				}


	}
}