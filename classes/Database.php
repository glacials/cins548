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

	  $statement = $this->connection->prepare('SELECT user_id, is_admin FROM Users WHERE username = ? AND password_hash = ?');
	  $statement->bind_param('ss',$username,$password);

	  if (!$statement->execute())
		  return false;

	  $statement->bind_result($result_user_id, $result_is_admin);
	  if($statement->fetch() == NULL) {
	  	$statement->close();
		return false;
	  }

	  $statement->close();

	  // Create array of user_id and is_admin, this will be returned so we can use this data
	  // for our session variables.
	  $results = array(
		  "user_id" => $result_user_id,
		  "is_admin" => $result_is_admin,
	  );

	  return $results;
  }

}
?>
