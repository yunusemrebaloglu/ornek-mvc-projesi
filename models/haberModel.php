<?php

 class haber extends db {
 	public $title;
 	public $detail;
 	public $kadi;
 	public $created_at;
 	protected $con;

 
	public function save()
	{
		// id değeri var mı
		if( is_null( $this->id ) ) {
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
		$add = $this->con->prepare("INSERT INTO haberler (title, detail, kadi) VALUES (:title, :detail, :kadi)");
		$result = $add->execute(array(
			'title' 		=> $this->title,
			'detail' 		=> $this->detail,
			'kadi' 			=> $this->kadi,
			));
		if($result) $this->id = $this->con->lastInsertId();
		return $result;
	}

	protected function update()
	{
		//	veritabanındaki mevcut kaydı güncelleme işlemlerini burada yapacağız
		$update = $this->con->prepare("UPDATE haberler SET title = :title, detail = :detail WHERE id = :id");
		$result = $update->execute(array(
			'id'			=> $this->id,
			'title' 		=> $this->title,
			'detail' 		=> $this->detail,
			));
		return $result;
	}
	public function initById($id)
	{
		$getRow = $this->con->prepare('SELECT * FROM haberler WHERE id = :id ');
		$getRow->execute(array(':id'=> $id));
		$haber = $getRow->fetch();
		if($haber) {
		$haber = (object)$haber;
		$this->id = $haber->id;
		$this->title = $haber->title;
		$this->detail = $haber->detail;
		$this->kadi = $haber->kadi;
		$this->created_at = $haber->created_at;

			return true;
		} else {
			return false;
		}
	}

	public static function find($id)
	{
		$haber = new self;
		if($haber->initById($id))
			return $haber;
		else
			return false;
	}
	public static function all($orderBy = "FIRST", $count = 5, $startFrom = 1)
	{
		$haber = new self;
		return $haber->getPosts($orderBy, $count, $startFrom);
	}
	public function getPosts($orderBy = "FIRST", $count = 5, $startFrom = 1){
		// db tarafına bu bilgileri kullanarak sorgu göndereceğiz, gelen sonucu dışarı döndüreceğiz
		if($orderBy==="FIRST") $orderByAtQuery = "ASC";
		elseif($orderBy==="LAST") $orderByAtQuery = "DESC";
		else $orderByAtQuery = "DESC";

		$count = (int)$count;
		$startFrom = (int)$startFrom;

		//$posts = $this->con->query("SELECT * FROM posts")->fetchAll(PDO::FETCH_ASSOC);;
		$all = $this->con->query("SELECT * FROM haberler ORDER BY created_at ".$orderByAtQuery." LIMIT ".$startFrom.", ".$count)->fetchAll(PDO::FETCH_OBJ);

		return $all;
	}
	public function deleteile($id)
	{
		$deletele = $this->con->exec("DELETE FROM haberler WHERE id = $id");
		if($deletele) {
			$this->id = null;
			$this->title = null;
			$this->detail = null;
			$this->kadi = null;
			$this->created_at = null;
				return $deletele;
				}
	}
	public static function haberdelete($id)
	{					
		$haber = new self;
		return $haber->deleteile($id);
	}
	public function searchBy($any)
	{
		$search = $this->con->query("SELECT * FROM haberler WHERE title LIKE '%$any%' OR detail LIKE '%$any%'")->fetchAll(PDO::FETCH_CLASS, 'haber');
		return $search;
	}

	public static function search($any)
	{
		$obj = new self;
		return $obj->searchBy($any);
	}	
	public function habercount()
	{
		$haberlersay = $this->con->query("SELECT COUNT(*) FROM haberler");
		$haberlersay ->execute();
		$haberlercount = $haberlersay->fetchColumn();
		return $haberlercount;
	}

	public static function haberlercount()
	{
		$obj = new self;
		return $obj->habercount();
	}	

}

