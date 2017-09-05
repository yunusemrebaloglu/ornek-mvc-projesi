<?php
 class admin extends db {
 	public $kadi;
 	public $password;
 	public $admin_seviye;
 	public $created_at;
 	protected $con;

	public function initBykadi($kadi, $parola)
	{
		$getRow = $this->con->prepare('SELECT * FROM admin WHERE kadi = :kadi AND parola = :parola');
		$getRow->execute(array(':kadi'=> $kadi,':parola'=>$parola));
		$kullanici = $getRow->fetch();
		if($kullanici) {
		$kullanici = (object)$kullanici;
		$this->id = $kullanici->id;
		$this->kadi = $kullanici->kadi;
		$this->admin_seviye = $kullanici->admin_seviye;

			return true;
		} else {
			return false;
		}
	}

	public static function login($kadi, $parola)
	{
		$admin = new self;
		if($admin->initBykadi($kadi, $parola))
			return $admin;
		else
			return false;
	}
	public function initById($id)
	{
		$getRow = $this->con->prepare('SELECT * FROM admin WHERE id = :id ');
		$getRow->execute(array(':id'=> $id));
		$kullanici = $getRow->fetch();
		if($kullanici) {
		$kullanici = (object)$kullanici;
		$this->id = $kullanici->id;
		$this->kadi = $kullanici->kadi;
		$this->parola = $kullanici->parola;
		$this->created_at = $kullanici->created_at;

			return true;
		} else {
			return false;
		}
	}

	public static function find($id)
	{
		$admin = new self;
		if($admin->initById($id))
			return $admin;
		else
			return false;
	}


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
		$add = $this->con->prepare("INSERT INTO admin (kadi, parola) VALUES (:kadi, :parola)");
		$result = $add->execute(array(
			'kadi' 			=> $this->kadi,
			'parola' 		=> $this->parola,
			));
		if($result) $this->id = $this->con->lastInsertId();
		return $result;
	}

	protected function update()
	{
		//	veritabanındaki mevcut kaydı güncelleme işlemlerini burada yapacağız
		$update = $this->con->prepare("UPDATE admin SET kadi = :kadi, parola = :parola WHERE id = :id");
		$result = $update->execute(array(
			'id'			=> $this->id,
			'kadi' 			=> $this->kadi,
			'parola' 		=> $this->parola,
			));
		return $result;
	}

	public function getAll($order = "FIRST")
	{
		$order = strtolower($order);
		$orderBy = "ASC";
		$availableOrders = ['first' => 'ASC', 'last' => 'DESC'];
		if(isset($availableOrders[$order])) $orderBy = $availableOrders[$order];
		$all = $this->con->query("SELECT * FROM admin ORDER BY created_at $orderBy")->fetchAll(PDO::FETCH_CLASS, 'admin');
		// var_dump($all);
		return $all;
	}


	public static function all($orderBy = "FIRST", $count = 5, $startFrom = 1)
	{
		$admin = new self;
		return $admin->getPosts($orderBy, $count, $startFrom);
	}


	public function getPosts($orderBy = "FIRST", $count = 5, $startFrom = 1){
		// db tarafına bu bilgileri kullanarak sorgu göndereceğiz, gelen sonucu dışarı döndüreceğiz
		if($orderBy==="FIRST") $orderByAtQuery = "ASC";
		elseif($orderBy==="LAST") $orderByAtQuery = "DESC";
		else $orderByAtQuery = "DESC";

		$count = (int)$count;
		$startFrom = (int)$startFrom;

		//$posts = $this->con->query("SELECT * FROM posts")->fetchAll(PDO::FETCH_ASSOC);;
		$all = $this->con->query("SELECT * FROM admin ORDER BY created_at ".$orderByAtQuery." LIMIT ".$startFrom.", ".$count)->fetchAll(PDO::FETCH_OBJ);

		return $all;
	}

	public function deleteile($id)
	{

		$deletele = $this->con->exec("DELETE FROM admin WHERE id = $id");
		if($deletele) {
			$this->id = null;
			$this->kadi = null;
			$this->parola = null;
			$this->created_at = null;
				return $deletele;
				}
		
	}
	public static function admindelete($id)
	{					
		$admin = new self;
		return $admin->deleteile($id);
	}
	public function searchBy($any)
	{
		$search = $this->con->query("SELECT * FROM admin WHERE kadi LIKE '%$any%'")->fetchAll(PDO::FETCH_CLASS, 'admin');
		return $search;
	}


	public static function search($any)
	{
		$obj = new self;
		return $obj->searchBy($any);
	}
	public function admincount()
	{
		$adminlerisay = $this->con->query("SELECT COUNT(*) FROM admin");
		$adminlerisay ->execute();
		$adminlercount = $adminlerisay->fetchColumn();
		return $adminlercount;
	}

	public static function adminlercount()
	{
		$obj = new self;
		return $obj->admincount();
	}	
}	



