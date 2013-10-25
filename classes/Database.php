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
    $statement = $this->connection->prepare('SELECT user_id, username, password_hash, is_admin, gender, updated, reset_question, reset_answer, address FROM Users WHERE user_id=?');
    $statement->bind_param('i', $id);
    if ($statement->execute()) {
      $statement->bind_result($id, $username, $password_hash, $is_admin, $gender, $updated, $reset_question, $reset_answer, $address);
      $statement->fetch();
      return new User($id, $username, $password_hash, $is_admin, $gender, $updated, $reset_question, $reset_answer, $address);
    }
    return false;
  }

  /* username_exists($username) {
   * Will take a username input, and check to see if that user exists in the database already.
   * It will use the username to check and see if it already exists in the database.
   * Useful when adding NEW users to webapp.
   */
  public function username_exists($username) {
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
    $statement->bind_param('i', $id);
    if ($statement->execute()) {
      $statement->bind_result($item_id, $item_name, $image_url, $item_description, $item_price);
      if ($statement->fetch() == NULL) {
        $statement->close();
        return false;
      }
      else {
        $statement->close();
        $product = new Product($item_id, $item_name, $image_url, $item_description, $item_price);
        return $product;
      }
    }
    $statment->close();
    return false;
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
    $query = '%' . $query . '%';
    $statement = $this->connection->prepare('SELECT item_id, item_name, image_url, item_description, item_price FROM Products WHERE item_name LIKE ?');
    $statement->bind_param('s', $query);

    if (!$statement->execute())
      return false;

    $statement->bind_result($product_id, $product_name, $product_image_url, $product_description, $product_price);

    $results = array();
    while ($statement->fetch()) {
      $product = new Product($product_id, $product_name, $product_image_url, $product_description, $product_price);
      $results[] = $product;
    }

    return $results;
  }

  /* get_purchases($user)
   * Returns an array of all Purchase objects belonging to user $user. $user can
   * be a User object or a user ID. If it's an ID and a user with that ID
   * doesn't exist, returns false. This function can be called from within the User class.
   */
  public function get_purchases($user_id) {
    // TODO: Not tested yet.
    $statement = $this->connection->prepare('SELECT Purchases.purchase_id, Purchases.user_id, Purchase_Items.item_id, purchase_date FROM Purchases JOIN Purchase_Items ON Purchases.purchase_id = Purchase_Items.purchase_id WHERE user_id = ?');
    $statement->bind_param('i',$user_id);
    if (!$statement->execute()) {
      return false;
    }
    $statement->bind_result($returned_purchase_id, $returned_user_id, $returned_item_id, $returned_purchase_date);

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
   * update_user($id, $username, $password, etc...)
   * This function will be used when a user is updated in the database.
   * It will take an arguement for each element pertaining to a user,
   * and update that record in the database.
   */
  public function update_user($id, $username, $password, $is_admin, $gender, $updated, $reset_question, $reset_answer, $address) {
    $statement = $this->connection->prepare('UPDATE Users SET username=?, password_hash=?, is_admin=?, gender=?, updated=?, reset_question=?, reset_answer=?, address=? WHERE user_id=?');
    $statement->bind_param('ssissssss',$username,$password,$is_admin,$gender,$updated,$reset_question,$reset_answer,$address,$id);
    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
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
    // TODO: NOT FULLY TESTED YET
    // 1. Insert into the Purchase table with purchase_id, user_id, and systemdate.
    // 2. Query the database for the purchase_id that was created for the insert. (autoincrement).
    // 3. Insert item_ids into the Purchase_Items table.

    $statement = $this->connection->prepare('INSERT INTO Purchases (purchase_id, user_id, purchase_date) VALUES(0,?,?)');
    $date = date('Y-m-d H:i:s');
    $statement->bind_param('is',$user_id,$date);
    if(!$statement->execute()) {
      $statement->close();
      return false;
    }
    else {
      $statement = $this->connection->prepare('SELECT purchase_id FROM Purchases WHERE (user_id = ? AND purchase_date = ?)');
      $statement->bind_param('is',$user_id,$date);
      if ($statement->execute()) {
        $statement->bind_result($generated_purchase_id);
        if ($statement->fetch() != true) {
          $statement->close();
          return false;
        }
        $statement->close();
        $statement = $this->connection->prepare('INSERT INTO Purchase_Items (purchase_id, item_id) VALUES (?,?)');
        foreach ($item_ids as $item_id) {
          $statement->bind_param('ii',$generated_purchase_id,$item_id);
          if (!$statement->execute()) {
            $statement->close();
            return false;
          }
        }
        $statement->close();
        return true;
      }
      else
        return false;
    }
  }

  /*
   * verify_creds($username, $password)
   * This function will check to see if the username and password are valid. Returns
   * user_id if valid, and FALSE if invalid.
   */
  public function verify_creds($username, $password) {
    $password = hash("sha256",$password . 'alPha548*3jasc');
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

  /*
   * This function will take a username as input, and return the user object
   * associated with that username. Used when resetting passwords.
   */

  public function get_user_from_username($username) {
    $user_id = '';
    $statement = $this->connection->prepare('SELECT user_id FROM Users WHERE username=?');
    $statement->bind_param('s', $username);
    if ($statement->execute()) {
      $statement->bind_result($user_id);
      if ($statement->fetch()) {
        $statement->close();
        $user_obj = $this->get_user($user_id);
        return $user_obj;
      }
    }
    $statement->close();
    return false;
  }

  /*
   * get_all_users()
   * This function will be used to get a list of all user objects that are stored in
   * the database. This will be used when the admin page requests all of the users.
   */
  public function get_all_users() {
    $statement = $this->connection->prepare('SELECT user_id, username, password_hash, is_admin, gender, updated, reset_question, reset_answer, address FROM Users');
    if ($statement->execute()) {
      $statement->bind_result($user_id, $username, $password_hash, $is_admin, $gender, $updated, $reset_question, $reset_answer, $address);
      $users = array();
      while ($statement->fetch()) {
        $user = new User($user_id, $username, $password_hash, $is_admin, $gender, $updated, $reset_question, $reset_answer, $address);
        array_push($users, $user);
      }
      return $users;
    }
    else {
      return false;
    }
  }
}
?>
