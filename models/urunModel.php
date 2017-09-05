<?php

 class urun extends db{
 	public $fiyat;
 	public $detail;
 	public $fotoname;
 	public $full_name;
 	public $kadi;
 	public $created_at;
 	protected $con;

	public function fotocontrol($foto)
	{
			$foto = $_FILES['photo'];
			if (isset($_FILES['photo'])) {
			    // dosya geldiyse fotoğraf olduğundan emin olalım
			       if ($_FILES['photo']){
			           if ($_FILES["photo"]["size"]<1024*1024){//Dosya boyutu 1Mb tan az olsun
			               if ($_FILES["photo"]["type"]=="image/png" || $_FILES["photo"]["type"]=="image/jpg" || $_FILES["photo"]["type"]=="image/jpeg" || $_FILES["photo"]["type"]=="image/gif" ){
			                   //dosya tipi jpeg olsun
			               //fotoğraf ise yeni bir isim verelim, "photos/" dizinimize kaydedelim
			               $uploadPath = "img/foto";
			               $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
			               $newName = sha1(md5(uniqid())) . "." . $extension;
			               $destination = $uploadPath . "/" . $newName;
			                    list($width, $height) = getimagesize($_FILES['photo']['tmp_name']);
			                   if ((!$width) && (!$height)) {
			                      header("Location: index.php"); 
			                  	}
			              $isUploaded = move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
			               // eğer kendi dizinimize kaydetme başarılı olursa ismini ve bu ekleme işlemini yapan kullanıcının bilgilerini,
					                if ($isUploaded) {	 
					                	$this ->fotoname = $newName;                   
										return true;
					                }
			                }
			           }
			       }
			}		
	}
	public static function fototrue($foto)
	{
		$foto = new self;
		if($foto->fotocontrol($foto))
			return $foto;
		else
			return false;
	}	
	public function save()
	{
		// id değeri var mı
		if( !isset( $this->id ) ) {
			//	yeni ekleme işlemi
			return $this->create();
		} else {
			//	güncelleme işlemi
			return $this->update();
		}
	}

	protected function create()
	{
		//	veritabanında yeni ekleme işlemlerini burada yapacağız
		$add = $this->con->prepare("INSERT INTO urunler (kadi, fotoname, full_name, fiyat ,detail) VALUES (:kadi, :fotoname, :full_name, :fiyat ,:detail)");
		$result = $add->execute(array(
			'kadi' 			=> $this->kadi,
			'fotoname' 		=> $this->fotoname,
			'full_name' 	=> $this->full_name,
			'fiyat' 		=> $this->fiyat,
			'detail' 		=> $this->detail,
			));
		if($result) $this->id = $this->con->lastInsertId();
		return $result;
	}

	protected function update()
	{
		//	veritabanındaki mevcut kaydı güncelleme işlemlerini burada yapacağız
		$update = $this->con->prepare("UPDATE urunler SET full_name = :full_name, detail = :detail, fotoname = :fotoname, fiyat = :fiyat WHERE id = :id");
		$result = $update->execute(array(
			'id'			=> $this->id,
			'full_name' 	=> $this->full_name,
			'detail' 		=> $this->detail,
			'fotoname' 		=> $this->fotoname,
			'fiyat' 		=> $this->fiyat,
			));
		return $result;
	}
	public static function all($orderBy = "FIRST", $count = 5, $startFrom = 1)
	{
		$urun = new self;
		return $urun->getPosts($orderBy, $count, $startFrom);
	}

	public function getPosts($orderBy = "FIRST", $count = 5, $startFrom = 1){
		// db tarafına bu bilgileri kullanarak sorgu göndereceğiz, gelen sonucu dışarı döndüreceğiz
		if($orderBy==="FIRST") $orderByAtQuery = "ASC";
		elseif($orderBy==="LAST") $orderByAtQuery = "DESC";
		else $orderByAtQuery = "DESC";

		$count = (int)$count;
		$startFrom = (int)$startFrom;

		//$posts = $this->con->query("SELECT * FROM posts")->fetchAll(PDO::FETCH_ASSOC);;
		$all = $this->con->query("SELECT * FROM urunler ORDER BY created_at ".$orderByAtQuery." LIMIT ".$startFrom.", ".$count)->fetchAll(PDO::FETCH_OBJ);

		return $all;
	}
	public function initById($id)
	{
		$getRow = $this->con->prepare('SELECT * FROM urunler WHERE id = :id ');
		$getRow->execute(array(':id'=> $id));
		$urun = $getRow->fetch();
		if($urun) {
		$urun = (object)$urun;
		$this->id = $urun->id;
		$this->kadi = $urun->kadi;
		$this->fotoname = $urun->fotoname;
		$this->fiyat = $urun->fiyat;
		$this->detail = $urun->detail;
		$this->full_name = $urun->full_name;
		$this->created_at = $urun->created_at;
			return true;
		} else {
			return false;
		}
	}

	public static function find($id)
	{
		$urun = new self;
		if($urun->initById($id))
			return $urun;
		else
			return false;
	}
	public function deleteile($id, $fotosilname)
	{
		if (isset($fotosilname)) {
			unlink("img/foto/$fotosilname");
		}
		$deletele = $this->con->exec("DELETE FROM urunler WHERE id = $id");
		if($deletele) {
			$this->id = null;
			$this->kadi = null;
			$this->fotoname = null;
			$this->detail = null;
			$this->fiyat = null;
			$this->full_name = null;
			$this->created_at = null;
				return $deletele;
				}
	}
	public static function urundelete($id, $fotosilname)
	{					
		$urun = new self;
		return $urun->deleteile($id, $fotosilname);
	}
	public function searchBy($any)
	{
		$search = $this->con->query("SELECT * FROM urunler WHERE full_name LIKE '%$any%' OR detail LIKE '%$any%' OR fiyat LIKE '%$any%'")->fetchAll(PDO::FETCH_CLASS, 'urun');
		return $search;
	}

	public static function search($any)
	{
		$obj = new self;
		return $obj->searchBy($any);
	}	
	public function uruncount()
	{
		$urunlersay = $this->con->query("SELECT COUNT(*) FROM urunler");
		$urunlersay ->execute();
		$urunlercount = $urunlersay->fetchColumn();
		return $urunlercount;
	}

	public static function urunlercount()
	{
		$obj = new self;
		return $obj->uruncount();
	}	

}

