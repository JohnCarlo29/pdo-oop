<?php
	class Users extends Database{
		private $username;
		private $password;

		public function __construct($uname, $pass){
			parent::__construct();
			$this->username = Cleaner::clean($uname);
			$this->password = Cleaner::clean($pass);
		}

		public function login(){
			Session::start();
			Session::setSession('user',$this->username);
		}

		public function checkUser(){
			$this->select("*", "users")->where("username")->build();
			$result = $this->execute([$this->username])->fetch();
			return password_verify($this->password,$result->password);
			
		}

		public function logout(){
			Session::unset_session('user');
			Session::destroy();
		}
	}

?>