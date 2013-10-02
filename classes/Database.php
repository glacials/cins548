<?php

class Database {

  private $connection;

  public function __construct() {
    $this->connection = new mysqli('localhost', 'webapp', 'teamalphacins548webapp', '548webapp');
  }

  /* get_user($id)
   * Returns a User object with ID $id. If no such user exists, returns false.
   */
  public function get_user($id) {
    // TODO: This ain't tested yet
    $statement = $this->connection->prepare('SELECT user_id, username, password_hash, is_admin, gender FROM Users WHERE user_id = ?');
    if ($statement->execute(array($id))) {
      $row = $statement->fetch();
      return new User($row['user_id'],
                      $row['username'],
                      $row['password_hash'],
                      $row['is_admin'],
                      $row['gender']);
    }
    return false;
  }

  /* user_exists($username) {
   * Will take a username input, and check to see if that user exists in the database already.
   * It will use the username to check and see if it already exists in the database.
   * Useful when adding NEW users to webapp.
   */
  public function user_exists($username) {
	  // TODO: Not tested yet.
	  $statement = $this->connection->prepare('SELECT username FROM Users WHERE username = ?');
	  $statement->bind_param('s', $username);
	  if ($statement->execute())
		  return false;
	  $statement->bind_results($result_username);
	  if ($statement->fetch() == NULL) {
		  $statement->close();
		  return false;
	  }
	  $statement->close();
	  return true;
  }

  /* get_item($id)
   * Returns an Item object with ID $id. If no such item exists, returns false.
   */
  public function get_item($id) {
	  $statement = $this->connection->prepare('SELECT item_id, item_name, image_url, item_description, item_price FROM Products WHERE item_id = ?');
	  $statement->bind_param('i',$id);
	  if ($statement->execute())
		  return false;
	  $statement->bind_results($item_id,$item_name,$image_url,$item_description,$item_price);
	  if ($statement->fetch() == NULL) {
		  $statement->close();
		  return false;
	  }
	  return new Product($item_id,$item_name,$image_url,$item_description,$item_price);
  }

  /* get_purchases($user)
   * Returns an array of all Purchase objects belonging to user $user. $user can
   * be a User object or a user ID. If it's an ID and a user with that ID
   * doesn't exist, returns false.
   */
  public function get_purchases($user) {
  }

  /*
   * verify_creds($username, $password)
   * This function will check to see if the username and password are valid. Returns
   * user_id if valid, and FALSE if invalid.
   */
  public function verify_creds($username, $password) {
	  $password = crypt($password, 'dLp#32A');

	  $statement = $this->connection->prepare('SELECT user_id FROM Users WHERE username = ? AND password_hash = ?');
	  $statement->bind_param('ss', $username, $password);

	  if (!$statement->execute())
		  return false;

	  $statement->bind_result($result_user_id);

	  if($statement->fetch() == NULL) {
	  	$statement->close();
		return false;
	  }

	  $statement->close();
	  $user_object = $this->get_user($result_user_id);
	  return $user_object;
  }

}
?>
