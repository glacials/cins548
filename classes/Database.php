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
	  $statement = $this->connection->prepare('SELECT user_id, username, password_hash, is_admin, gender, reset_question, reset_answer, address FROM Users WHERE user_id=?');
    $statement->bind_param('i', $id);
    if ($statement->execute()) {
      $statement->bind_result($id, $username, $password_hash, $is_admin, $gender, $reset_question, $reset_answer, $address);
      $statement->fetch();
      return new User($id, $username, $password_hash, $is_admin, $gender, $reset_question, $reset_answer, $address);
    }
    return false;
  }

  /* username_exists($username) {
   * Will take a username input, and check to see if that user exists in the database already.
   * It will use the username to check and see if it already exists in the database.
   * Useful when adding NEW users to webapp.
   */
  public function username_exists($username) {
	  // TODO: Not tested yet.
	  $statement = $this->connection->prepare('SELECT username FROM Users WHERE username = ?');
	  $statement->bind_param('s', $username);
	  if (!$statement->execute())
		  return false;
	  $statement->bind_result($result_username);
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
    if (!$statement->execute())
      return false;
    $statement->bind_result($item_id, $item_name, $image_url,
                             $item_description, $item_price);
	  if ($statement->fetch() == NULL) {
		  $statement->close();
		  return false;
	  }
	  return new Product($item_id,$item_name,$image_url,$item_description,$item_price);
  }

  /*get_all_products()
   * Can be used to get an array of all products that are currently in the database.
   */
  public function get_all_products() {
	  // TODO: Not Tested
	  $statement = $this->connection->prepare('SELECT item_id, item_name, image_url, item_description, item_price FROM Products');

	  if(!$statement->execute())
		  return false;

	  $statement->bind_result($returned_item_id, $returned_item_name, $returned_image_url, $returned_item_description, $returned_item_price);

	  $array_of_results = array();

	  while ($statement->fetch()) {
		  $item = new Product($returned_item_id,$returned_item_name,$returned_image_url,$returned_item_description,$returned_item_price);
		  $array_of_results[] = $item;
	  }

	  if (empty($array_of_results))
		  return false;
	  else
		  return $array_of_results;
  }

  public function get_products_like($query) {
    $statement = $this->connection->prepare('SELECT item_id, item_name, image_url, item_description, item_price FROM Products WHERE (item_name LIKE ?) OR (item_description LIKE ?)');
    $statement->bind_param('ss', $query, $query);

    if (!$statement->execute())
      return false;

    $statement->bind_result($product_id, $product_name, $product_image_url, $product_description, $product_price);

    while ($statement->fetch()) {
      $product = new Product($product_id, $product_name, $product_image_url, $product_description, $product_price);
      $results[] = $product;
    }

    if (empty($results))
      return false;
    return $results;
  }

  /* get_purchases($user)
   * Returns an array of all Purchase objects belonging to user $user. $user can
   * be a User object or a user ID. If it's an ID and a user with that ID
   * doesn't exist, returns false. This function can be called from within the User class.
   */
  public function get_purchases($user_id) {
	  // TODO: Not tested yet.
	  $statement = $this->connection->prepare('SELECT purchase_id, user_id, item_id, purchase_date FROM Purchases WHERE user_id = ?');
	  $statement->bind_param('i',$user_id);
	  if (!$statement->execute()) {
		  return false;
	  }
	  $statement->bind_results($returned_purchase_id, $returned_user_id, $returned_item_id, $returned_purchase_date);

	  $array_of_puchases = array();

	  while ($statement->fetch()) {
		  $item = new Purchase($returned_purchase_id, $returned_user_id, $returned_item_id, $returned_purchase_date);
		  $array_of_purchases[] = $item;
	  }

	  // If there are no purchases in the the results, return false
	  if (empty($array_of_purchases))
		  return false;
	  return $array_of_purchases;
  }

  /*
   * insert_user($id, $username, $password, $is_admin)
   * This function will simply insert this data in to the user tabe in the database. This function will be used when the user
   * try to enroll with our webapp.
   */
  public function insert_user($id, $username, $password, $is_admin, $gender, $reset_question, $reset_answer, $address) {
	  $statement = $this->connection->prepare('INSERT INTO Users (user_id, username, password_hash, is_admin, gender, updated, reset_question, reset_answer, address) VALUES(?,?,?,?,?,?,?,?,?)');
	  $date = date('Y-m-d H:i:s');
	  $statement->bind_param('sssisssss',$id,$username,$password,$is_admin,$gender,$date,$reset_question,$reset_answer,$address);
	  if($statement->execute()) {
		  return true;
	  }
	  else
		  return false;
  }

  /*
   * create purchase($user_id, $item_ids)
   * This function will create a new Purchase in the database. It will insert data into the Purchases table
   * along with the Purchase_Items table.
   */
  public function create_purchase($user_id, $item_ids) {
	  // 1. Insert into the Purchase table with purchase_id, user_id, and systemdate.
	  // 2. Query the database for the purchase_id that was created for the insert. (autoincrement).
	  // 3. Insert item_ids into the Purchase_Items table.
  }

  /*
   * verify_creds($username, $password)
   * This function will check to see if the username and password are valid. Returns
   * user_id if valid, and FALSE if invalid.
   */
  public function verify_creds($username, $password) {
	  $password = crypt($password, 'dLp#32A');
	  $statement = $this->connection->prepare('SELECT user_id FROM Users WHERE username=? AND password_hash=?');

	  $statement->bind_param('ss', $username, $password);
	  if ($statement->execute()) {
		  $statement->bind_result($user_id);
		  if ($statement->fetch()) {
			  $statement->close();
			  $user_obj = $this->get_user($user_id);
			  return $user_obj;
		  }
	  }
	  $statement->close();
  }
}
?>
