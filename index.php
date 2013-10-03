<?php

require_once 'autoload.php';

session_start();
$db = new Database;

// Testing the login stuff. The second argument replaces '{page_title}' in header.html.
if (isset($_SESSION['user'])) {
  print 'Logged in! <a href="logout.php">Logout</a>';
}

if (isset($_GET['login'])) {
  $page = new Page('login.html', array('page_title' => 'Login'));
  print $page->html;
} elseif (isset($_GET['signup'])) {
  $page = new Page('signup.html', array('page_title' => 'Sign up'));
} else {
  $page = new Page('index.html', array('page_title' => 'Home'));
}
print $page->html;

?>
