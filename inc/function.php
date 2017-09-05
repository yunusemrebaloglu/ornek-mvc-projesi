<?php
// eğer session yapıldı yapılmadı kısımlarını göstemek için yapıldı  
function redirectIfNotLoggedIn()
{
	if(!isset($_SESSION['admin'])) {
	//	kullanıcı girişi yok, forma yönlendirelim
		header("Location: login.php");
		die();
	}
}

function redirectIfLoggedIn()
{
	if(isset($_SESSION['admin'])) {
	//	kullanıcı girişi var, indexe yönlendirelim
		header("Location: index.php");
		die();
	}
}
// sadece üst düzey adminin girişi için yapıldı
function yetki()
{
		 if (isset($_SESSION)) {

			if ($_SESSION['admin_seviye'] !=1 ) {
				header("Location: index.php");
			}
		}elseif (!isset($_SESSION)) {
			header("Location: index.php");
		}	
}
// kelime sınırı ile anasayfada gösterilen yada bu fonksiyona gelen veriyi sınırlandırmak için yapıldı.
function kelimesiniri($metin)
{	
	$uzunluk = strlen($metin);
	if ($uzunluk > 270) {
	$metin = substr($metin,0,270) . "&nbsp;" . "...";
	echo $metin;
	}else {
			echo $metin;
	}
}
// yetki ziyaret fonksiyonu sadece giriş yapmış admin için yapıldı.
function yetkiziyaret ()
{
		 if (isset($_SESSION)) {

			if ($_SESSION['admin'] !=true  ) {
				header("Location: index.php");
			}
		}elseif (!isset($_SESSION)) {
			header("Location: index.php");
		}
}

function gelenvericontroller(){
	// giren ilk ziyaretçiye ürünlerimizi gösterdik

	if (empty($_GET)) {
		UrunController::list();
	}elseif(isset($_GET)) {
		$name = htmlentities(key($_GET));
		// eğer get varsa keyden gelen ilk indisimizi controller  adı ile birleştirip control  name oluşturduk.
		$Controlname = $name.'Controller';

		//ilk indisimizin döndürdüğü veri varmı diyerek baktık ( çok saçma birşekilde baktım farkındayım gece 04,36)
		if( method_exists($Controlname,$_GET[$name]) ) {
			//actionumuz ise yukarıda saçma birşekilde ilk indisimizin verisi varmı diye baktık.
			$action = $_GET[$name];
			$Controlname::$action();
		}
	}
}