<?php
/**
 * PDO Database Access Class
 * 
 * @copyright EU-Create All Rights Reserved.
 * @auther EU-Create <eucreate@gmail.com>
 */

//========================================================================================================
// PDOデータベース接続
//========================================================================================================
class dbc {
	public $isConnected;
	public $cHostName;
	public $cUserName;
	public $cPassword;
	public $cDatabase;
	public $cSqlitePath;
	public $cDbType;
	public $cCon;
	function __construct() {
		$this->cHostName = dbServer;
		$this->cUserName = dbUser;
		$this->cPassword = dbPass;
		$this->cDatabase = dbName;
		$this->cSqlitePath = sqlitePath;
		$this->cDbType = dbType;
		//データベースへ接続
		try {
			$this->isConnected = true;
			if ($this->cDbType === "sqlite") {
				//SQLite
				$this->cCon = new PDO("sqlite:{$this->cSqlitePath}{$this->cHostName}");
			} else if ($this->cDbType === "MySQL") {
				//MySQL
				$this->cCon = new PDO("mysql:dbname=$this->cDatabase;host=$this->cHostName", $this->cUserName, $this->cPassword, array(PDO::ATTR_EMULATE_PREPARES=>false, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			}
		} catch(PDOException $e) { 
			$this->isConnected = false;
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 検索結果(1回のみ)
	//---------------------------
	function getRowOnce($query) {
		try {
			$stmt = $this->cCon->query($query);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 検索結果
	//---------------------------
	function getRow($query, $params=array()) {
		try {
			$stmt = $this->cCon->prepare($query);
			$stmt->execute($params);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 行数(SELECT)1回のみ
	//---------------------------
	function getRowSelectOnce($query) {
		try {
			$stmt = $this->cCon->query($query);
			return $stmt->fetchColumn();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 行数(SELECT)
	//---------------------------
	function getRowSelect($query, $params=array()) {
		try {
			$stmt = $this->cCon->prepare($query);
			$stmt->execute($params);
			return $stmt->fetchColumn();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// INSERT, UPDATE, DELETE
	//---------------------------
	public function insertRow($query, $params){
		try{
			$stmt = $this->cCon->prepare($query);
			$stmt->execute($params);
			return intval($this->cCon->lastInsertId());
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	public function updateRow($query, $params){
		return $this->insertRow($query, $params);
	}
	public function deleteRow($query, $params){
		return $this->insertRow($query, $params);
	}
	//---------------------------
	// INSERT, UPDATE, DELETE(ONCE)
	//---------------------------
	public function insertRowOnce($query){
		try{
			$stmt = $this->cCon->query($query);
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	public function updateRowOnce($query){
		return $this->insertRowOnce($query);
	}
	public function deleteRowOnce($query){
		return $this->insertRowOnce($query);
	}
	//---------------------------
	// カーソルを閉じてステートメントを再実行できるようにする
	//---------------------------
	public function closeCursul() {
		$this->cCon->closeCursul();
	}
	//---------------------------
	// データベースをクローズ
	//---------------------------
	function Disconnect() {
		$this->cCon = null;
	}
}
