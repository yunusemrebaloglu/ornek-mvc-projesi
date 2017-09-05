<?php

 class foto extends db{
 	public $fotoname;
 	public $detail;
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
		$add = $this->con->prepare("INSERT INTO foto (kadi, fotoname, full_name ,detail) VALUES (:kadi, :fotoname, :full_name ,:detail)");
		$result = $add->execute(array(
			'kadi' 			=> $this->kadi,
			'fotoname' 		=> $this->fotoname,
			'full_name' 	=> $this->full_name,
			'detail' 		=> $this->detail,
			));
		if($result) $this->id = $this->con->lastInsertId();
		return $result;
	}

	protected function update()
	{
		//	veritabanındaki mevcut kaydı güncelleme işlemlerini burada yapacağız
		$update = $this->con->prepare("UPDATE foto SET full_name = :full_name, detail = :detail, fotoname = :fotoname WHERE id = :id");
		$result = $update->execute(array(
			'id'			=> $this->id,
			'full_name' 	=> $this->full_name,
			'detail' 		=> $this->detail,
			'fotoname' 		=> $this->fotoname,
			));
		return $result;
	}
	public static function all($orderBy = "FIRST", $count = 5, $startFrom = 1)
	{
		$foto = new self;
		return $foto->getPosts($orderBy, $count, $startFrom);
	}
	public function getPosts($orderBy = "FIRST", $count = 5, $startFrom = 1){
		// db tarafına bu bilgileri kullanarak sorgu göndereceğiz, gelen sonucu dışarı döndüreceğiz
		if($orderBy==="FIRST") $orderByAtQuery = "ASC";
		elseif($orderBy==="LAST") $orderByAtQuery = "DESC";
		else $orderByAtQuery = "DESC";

		$count = (int)$count;
		$startFrom = (int)$startFrom;

		//$posts = $this->con->query("SELECT * FROM posts")->fetchAll(PDO::FETCH_ASSOC);;
		$all = $this->con->query("SELECT * FROM foto ORDER BY created_at ".$orderByAtQuery." LIMIT ".$startFrom.", ".$count)->fetchAll(PDO::FETCH_OBJ);

		return $all;
	}
	public function initById($id)
	{
		$getRow = $this->con->prepare('SELECT * FROM foto WHERE id = :id ');
		$getRow->execute(array(':id'=> $id));
		$foto = $getRow->fetch();
		if($foto) {
		$foto = (object)$foto;
		$this->id = $foto->id;
		$this->kadi = $foto->kadi;
		$this->fotoname = $foto->fotoname;
		$this->detail = $foto->detail;
		$this->full_name = $foto->full_name;
		$this->created_at = $foto->created_at;
			return true;
		} else {
			return false;
		}
	}

	public static function find($id)
	{
		$foto = new self;
		if($foto->initById($id))
			return $foto;
		else
			return false;
	}
	public function deleteile($id, $fotosilname)
	{
		if (isset($fotosilname)) {
			unlink("img/foto/$fotosilname");
		}
		$deletele = $this->con->exec("DELETE FROM foto WHERE id = $id");
		if($deletele) {
			$this->id = null;
			$this->kadi = null;
			$this->fotoname = null;
			$this->detail = null;
			$this->full_name = null;
			$this->created_at = null;
				return $deletele;
				}
	}
	public function deletefoto(){
	}
	public static function fotodelete($id, $fotosilname)
	{					
		$foto = new self;
		return $foto->deleteile($id, $fotosilname);
	}
	public function searchBy($any)
	{
		$search = $this->con->query("SELECT * FROM foto WHERE kadi LIKE '%$any%' OR detail LIKE '%$any%' OR full_name LIKE '%$any%'")->fetchAll(PDO::FETCH_CLASS, 'foto');
		return $search;
	}

	public static function search($any)
	{
		$obj = new self;
		return $obj->searchBy($any);
	}
	public function fotocount()
	{
		$fotolarisay = $this->con->query("SELECT COUNT(*) FROM foto");
		$fotolarisay ->execute();
		$fotolarcount = $fotolarisay->fetchColumn();
		return $fotolarcount;
	}

	public static function fotolarcount()
	{
		$obj = new self;
		return $obj->fotocount();
	}		
	

}

