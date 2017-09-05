<?php
class db
{
	/**
	 * Veritabanını nesnesini tutar
	 * @var void
	 */
	public $db;

	/**
	 * Veritabanı nesnesini oluşturur
	 */
	public function __construct()
	{
		$this->con = new PDO("mysql:host=localhost;dbname=demo;charset=utf8", "root", "");
	}
}