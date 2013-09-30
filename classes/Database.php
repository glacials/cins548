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
   * This function will check to see if the username and password are valid. Returns
   * user_id if valid, and FALSE if invalid.
   */
  public function verify_creds($username, $password) {
	  $password = crypt($password, 'dLp#32A');

	  $statement = $this->connection->prepare('SELECT user_id FROM Users WHERE username = ? AND password_hash = ?');
	  $statement->bind_param('ss',$username,$password);

	  if (!$statement->execute())
		  return false;

	  $statement->bind_result($results);
	  $statement->fetch();
	  $statement->close();

	  if ($results == null)
		  return true;
	  else
		  return $results;
  }

}

?>
