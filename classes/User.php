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

	/*
	 * is_admin();
	 * Will return if a user is an admin or not.
	 */
	public function is_admin() {
		return $this->is_admin == 1;
	}

	/*
	 * exists();
	 * Will call $db->get_user($user_id) and see if the user already exists in the database
	 */
	public function exists() {
		return (bool)$db->get_user($this->user_id);
	}

	/* purchases();
	 * Call the Database::get_purchases($user_id) function, and return an array of purchase objects
	 * This will create a nice way to get purchases for a particular user.
	 * Ex:	$purchases =  $user_obj->purchases()
	 */
	public function purchases() {
		// TODO: Not tested yet.
		return $db->get_purchases($this->id);
	}

  /*
   * Saves the current user to the database. If this is a new user, runs an
   * insert. If it's an existing user, runs an update.
   */
  public function save() {
    //todo
  }
}

?>
