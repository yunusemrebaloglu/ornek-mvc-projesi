<?php
require_once 'inc/init.php';

class HaberController {
	public static function add()
	{	
		yetkiziyaret();
		include'views/haber/addhaber.php';
			if ($_POST) {
				if(isset($_POST['title']) AND isset($_POST['detail'])){
					$post = new haber;
					$post->kadi = $_SESSION['kadi'];
					$post->title = $_POST['title'];
					$post->detail = $_POST['detail'];
					$post->save();
					if ($post) {
					header("Location: ?haber=birhaber&id=$post->id");
					}
				}
			}
	}
	public static function birhaber(){
		$id = (int)$_GET['id'];
		if($id == 0 ) header("Location: index.php");
		$post = haber::find($id);
		if ($post) {
		include'views/haber/haberdetail.php';
		}else {
			header("Location: index.php");
		}
	}
	public static function list()
	{	if (empty($_POST['search'])) {
		$kactane = 10;
		$kactan = 0;
		$haberlercount = haber::haberlercount();
		$sayfasayisi = ceil($haberlercount/$kactane);
		$sayfa = 1 ;	
		if (isset($_GET['sayfa'])) {
			$sayfa = (int)$_GET['sayfa'];
			if ($sayfa ==1) {
				$kactane = 10;
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
        $haberler = haber::all($orderBy = "LAST", $count = $kactane, $startFrom = $kactan);
		$searchvalue= null;
		}
		if (isset($_POST['search'])){
		$search=$_POST['search'];
		$searchvalue	= $search;	
		$haberler   	=haber::search($search);
		}
		include "views/haber/listhaber.php";
	}
	public static function delete()
	{		
			yetkiziyaret();
			$id = (int)$_GET['id'];
			$haber = haber::haberdelete($id);
			header("Location: ?haber=list");


	}
	public static function update()
	{	
		yetkiziyaret();
		$id = $_GET['id'];
		$post = haber::find($id);
		include'views/haber/edithaber.php';
			if ($_POST) {
				if(isset($_POST['title']) AND isset($_POST['detail'])){
					$post->title = $_POST['title'];
					$post->detail = $_POST['detail'];
					$post->save();
					if ($post) {
					header("Location: ?haber=list");
					}
				}
			}
	}


}