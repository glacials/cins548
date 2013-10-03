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
    $statement->bind_param('i', $id);
    if ($statement->execute()) {
      $statement->bind_result($id, $username, $password_hash, $is_admin, $gender);
      $statement->fetch();
      return new User($id, $username, $password_hash, $is_admin, $gender);
    }
    return false;
  }

  /* get_item($id)
   * Returns an Item object with ID $id. If no such item exists, returns false.
   */
  public function get_item($id) {
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
