<?php
/*
 * This page will authenticate users and create session variables, that tells
 * the webapp that the user is authenticated, and they are allowed to browse to
 * other pages. Input will be given via a POST from the login.html page.
 */

require_once 'autoload.php';

session_start();

$db = new Database;

$user = $db->verify_creds($_POST['email'],$_POST['password']);

if ($user) {
  $_SESSION['user'] = $user;
  $_SESSION['cart'] = array(); // An array of product_ids.
  $_SESSION['notice'] = 'Successfully logged in.';
  header('Location: ?');
} else {
  $_SESSION['error'] = 'Invalid user credentials, please try again.';
  header('Location: ?login');
}

?>
