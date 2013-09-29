<?php

class Database {

  public $connection;

  public function __construct($host, $username, $password, $database) {
    $this->connection = new mysqli($host, $username, $password, $database);
  }

  /* get_user($id)
   * Returns a User object with ID $id. If no such user exists, returns false.
   */
  public function get_user($id) {
    // TODO: This ain't tested yet
    $user = new User;
    $statement = $connection->prepare('SELECT id, email, password, gender FROM users WHERE id = ?');
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
}

?>
