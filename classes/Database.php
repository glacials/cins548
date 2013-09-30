<?php

class Database {

  public $connection;

  public function __construct() {
    $this->connection = new mysqli('localhost', 'webapp', 'teamalphacins548webapp', '548webapp');
  }

  /* get_user($id)
   * Returns a User object with ID $id. If no such user exists, returns false.
   */
  public function get_user($id) {
    // TODO: This ain't tested yet
    $user = new User;
    $statement = $this->connection->prepare('SELECT id, email, password, gender FROM Users WHERE id = ?');
    $statement->bind_param('d', $id);
    if (!$statement->execute())
      return false;
    $statement->bind_result($user->id, $user->email, $user->password, $user->gender);
    $statement->fetch();
    $statement->close();
    return $user;
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
   * This function will check to see if the username and password are valid.
   */
  public function verify_creds($username, $password) {
	  // Escape characters here!

	  // Hashing our password (password, salt)
	  $password = crypt($password, 'dLp#32A');

	  $result = $this->connection->query("SELECT user_id FROM Users WHERE username = '$username' AND password_hash = '$password'");

	  $row_count = $result->num_rows;

	  if ($row_count == 1)
		  return true;
	  else
		  return false;
  }

}

?>
