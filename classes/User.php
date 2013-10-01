<?php

class User {

	private $id;
	private $username;
	private $password_hash;
	private $is_admin;
	private $gender;

	function __construct($Id, $Username, $Password_hash, $Is_admin, $Gender) {
		$this->id = $ID;
		$this->username = $Username;
		$this->password_hash = $Password_hash;
		$this->is_admin = $Is_admin;
		$this->gender = $Gender;
	}

	public function is_admin() {
		if ($is_admin)
			return true;
		else
			return false;
	}
}

?>
