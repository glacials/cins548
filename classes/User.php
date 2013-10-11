<?php

class User {

	private $id;
	private $username;
	private $password_hash;
	private $is_admin;
	private $reset_question;
	private $reset_answer;
	private $address;
	private $gender;

	public function __construct($Id, $Username, $Password_hash, $Is_admin, $Gender, $Reset_question, $Reset_answer, $Address) {
		$this->id = $Id;
		$this->username = $Username;
		$this->password_hash = $Password_hash;
		$this->is_admin = $Is_admin;
		$this->gender = $Gender;
		$this->reset_question = $Reset_question;
		$this->reset_answer = $Reset_answer;
		$this->address = $Address;
	}

  /*
   * __get($var);
   * Lets us read class member variables without writing individual getter
   * functions. Now we can access the variables as if they were public, but we
   * have no write access to them. Also, we can restrict which variables can be
   * accessed like this with the $allowed_vars array below.
   */
  public function __get($var) {
    $allowed_vars = array('id', 'username', 'is_admin', 'gender', 'reset_question', 'address');
    if (in_array($var, $allowed_vars))
      return $this->$var;
    else
      return false;
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
   * insert. If it's an existing user, runs an update. Params = 'update' or 'insert'.
   */
	public function save($param) {
		$db = new Database;

		// This section is for inserting a new user. Used with the signup page.
		if ($param == 'insert') {
			if (!$db->username_exists($this->username)) {
				return $db->insert_user(0,$this->username,$this->password_hash,$this->is_admin, $this->gender, $this->reset_question, $this->reset_answer, $this->address);
			}
			else
				return false;
		}
		
		// This section is for updating a user. Used with the page where admins/users can
		// change their personal data.
		if ($param == 'update') {
			// Haven't implemented fully.
		}
	}

	/* checkout(array_of_products)
	 * This function will be called when the user is ready to checkout.
	 * This function will end up calling a "create_purchase" function in the 
	 * Database class which will add the products and transaction information to the database.
	 */

	public function checkout($cart) {
		$db = new Database;
		$item_ids = array();
		foreach ($cart as $item) {
			array_push($item_ids, $item->id);
		}
		$db->create_purchase($this->id, $item_ids);
		return true;
	}

}

?>
