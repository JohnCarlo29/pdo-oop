<?php
	abstract class Database{
		private $host 		= "localhost";
		private $dbname 	= "ccj";
		private $dbusername = "root";
		private $dbpass 	= "";
		private $db;
		private $stmt;

		public function __construct(){
			//$dsn = "mysql:host =". $this->host . ";dbname = ". $this->dbname;
			try{
				$this->db = new PDO('mysql:host=localhost;dbname=ccj','root','');
			}catch(PDOException $e){
				$e->getMessage();
			}
		}

		public function select($fields, $table){
			$this->stmt = "Select ". $fields ." From ".$table;
			return $this;
		}

		public function where($where){
			$this->stmt.= " Where ".$where." = ?";
			return $this;
		}

		public function and_where($where){
			$this->stmt.= " AND ".$where." = ?";
			return $this;
		}

		public function or_where($where){
			$this->stmt.= " OR ".$where." = ?";
			return $this;
		}

		public function greater_where($where){
			$this->stmt.= " Where ".$where." < ?";
			return $this;
		}

		public function greaterEqual_where($where){
			$this->stmt.= " Where ".$where." >= ?";
			return $this;
		}

		public function lessThan_where($where){
			$this->stmt.= " Where ".$where." < ?";
			return $this;
		}

		public function insert($table, $fields=array()){
			$field = implode(", ", $fields);
			$values = "?";
			$this->stmt = "Insert into ".$table." ({$field})";
			for ($i=1; $i<count($fields);$i++){
				$values.=", ?";
			}
			$this->stmt.= " VALUES({$values})";

			return $this;
		}

		public function delete($table){
			$this->stmt = "Delete from ".$table;
			return $this;
		}

		public function update($table, $field){
			$this->stmt = "Update ".$table." set ".$field. " = ? ";
			return $this;
		}

		public function up_new_field($field){
			$this->stmt.= ", ".$field." = ? ";
			return $this;
		}

		public function orderBy($field, $order){
			$this->stmt.=" ORDER BY ".$field." ".$order;
			return $this;
		}

		public function limit($offset, $row){
			$this->stmt.=" limit ".$offset.",".$row;
			return $this;
		}

		public function query($sql){
			$this->stmt = $sql;
			return $this;
		}

		public function build(){
			return $this->stmt;
		}

		public function execute($values=array()){
			$this->stmt = $this->db->prepare($this->stmt);
			$this->stmt->execute($values);
			return $this;
		}

		public function fetch_all(){
			$results = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return $results;
		}

		public function fetch(){
			$results = $this->stmt->fetch(PDO::FETCH_OBJ);
			return $results;
		}

		public function rowCount(){
			return $this->stmt->rowCount();
		}

		public function getLastInserted(){
			return $this->db->lastInsertId();
		}

		public function __destruct(){
			$this->db = null;
			$this->stmt = null;
		}		
	}
?>