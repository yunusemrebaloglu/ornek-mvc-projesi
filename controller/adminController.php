<?php
// admin girişi için oluşturulmuş bir kontroldür ve ve bir alt satırda ise gerekli doyalarımızı çektik.
require_once 'inc/init.php';

class AdminController {
	public static function adminlogin()
	{
			// login işlemi için gereken bilgileri buradan alıp modelimizdeki login kısmına yönlendirip girişi yaptırdıktan sonra session a kayıtımızı yaptık. redirectIfLoggedIn() fonksiyoni ilede session varsa buraya gelmesini engelledik.
			redirectIfLoggedIn();
			$yanlis = "Lütfen bilgilerinizi giriniz.";
			if($_POST)
			{
					$kadi = htmlentities($_POST['kadi']);
					$parola = htmlentities($_POST['parola']);
					$admin = admin::login($kadi, $parola);
					if ($admin) {
						$_SESSION['admin'] = true;
						$_SESSION['kadi']= $admin->kadi;
						$_SESSION['admin_seviye']= $admin->admin_seviye;
						header("Location: index.php");

					}else{
						$yanlis = "Hatalı bilgiler girdiniz, tekrar deneyiniz.";
					}
			}
		include "views/admin/login.php";

	}
	public static function logout(){
		session_destroy();
		header("Location: index.php");
	}

	public static function add()
	{	
		// üst düzey kullanıcının admin eklemesi için admin kayıt işlemi yapıldı ve yetki fonksiyonu ile sadece üst düzey admin bu işlemi yapacaktır.
		yetki();
		include'views/admin/add_admin.php';
			if ($_POST) {

				if(isset($_POST['kadi']) AND isset($_POST['parola'])){
					$post = new admin;
					$post->kadi = $_POST['kadi'];
					$post->parola = $_POST['parola'];
					$post->save();
					if ($post) {
					header("Location: ?admin=list");
					}
				}
			}
	}
	public static function update()
	{	
		// üst düzey adminin diğer adminlerin profillerini güncellemek için yapılan kısım.
		yetki();
		$id = $_GET['id'];
		$post = admin::find($id);
		include'views/admin/editadmin.php';
			if ($_POST) {

				if(isset($_POST['kadi']) AND isset($_POST['parola'])){
					$post->kadi = $_POST['kadi'];
					$post->parola = $_POST['parola'];
					$post->save();
					if ($post) {
					header("Location: ?admin=list");
					}
				}
			}
	}
	public static function list()
	{
        yetki();
		// search olarak post yoluyla sayfa yolladık yoksa normal sayfalanma yapılan işlemin kısımı yoksa arama kısmı çalışacak
		if (empty($_POST['search'])) {
// satfamızda kaç adet sergileneceğini girdik burada ve kaçtan başlayacağını
		$kactane = 20;
		$kactan = 0;
		// toplam sergilenecek sayıyımızı bulduk
		$admincount = admin::adminlercount();
		// sayfa sayısını hesaplamak için toplam sayfa sayıyımızı kaç adet olacağına bölüm yuvarlanmasını aldık aldık
		$sayfasayisi = ceil($admincount/$kactane);
		// başlangıç olarak sayfamızı bir aldık
		$sayfa = 1 ;	
		// getten bir sayfa varsa;
		if (isset($_GET['sayfa'])) {
			// getten ggelen sayfayı sayfa değişkenine aldık
			$sayfa = (int)$_GET['sayfa'];
			// eğer sayfa 1 e eşitse 20 tane yine ve 0 dan başlayarak sergiledik.
			if ($sayfa ==1) {
				$kactane = 20;
				$kactan = 0;
				// eğer bire eşit değilse olarak ;
			}elseif ($sayfa!=1) 
			{	
				// sayfa sayımızı getten gelen sayfanın sayısından küçük olması  koşulu ekledik
				if ($sayfa > $sayfasayisi ) {
					header("Location: index.php");
				}
				// buraya kadar sıkıntı yoksa kaçtan başlayacağını hesaplayıp sayfalama ksımımızın en enönemli kısmına döndük.
				// kaçtan başlayacağını sayfaya gelen get ile olan sayfa sayınısı kaç tane saydıracağıkmız ile çarpıp kaçtane saydıracağımızı çıkarttık. ilk önce mantığını anlayıp bunu deneme yanılma olarak yaptığımı itiraf etmek zorundayım.
				$kactan = ($sayfa * $kactane) - ($kactane);
			}
		}	
			// sonraki sayfa butonumuz için wiev kısmında kod yazmak istemediğimden burda yazdım.
			if ($sayfa != $sayfasayisi) {
				$sonrakisayfa = $sayfa+1 ;
			}
			if ($sayfa != 1) {
				$oncekisayfa =$sayfa -1 ;
			}
		// sadece yüksek düzeyli adminin diğer adminleri listelemesi için yapılan kısım.
        // bundan sonrada sadece model kısmımıza yukarıda yaptığımız fonksiyonlardan gelen değerleri yollamak kalşdı.
        $adminler = admin::all($orderBy = "LAST", $count = $kactane, $startFrom = $kactan );
		$searchvalue= null;
		}
		if (isset($_POST['search'])){
			$search=$_POST['search'];
		$searchvalue= $search;	
		$adminler =	admin::search($search);
		}
		include "views/admin/listadmin.php";
	}

	public static function delete()
	{
			// yüksek düzeyli adminin diğer adminleri silmesi için yapılan kısım.
			yetki();
			$id = (int)$_GET['id'];
			$admin = admin::admindelete($id);
			header("Location: ?admin=list");


	}


}