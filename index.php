<?php

require_once 'autoload.php';

$db = new Database;

// Testing the login stuff. The second argument replaces '{page_title}' in header.html.
if (isset($_SESSION['user'])) {
  print 'Logged in! <a href="logout.php">Logout</a>';
} else {
  $page = new Page('login.html', array('page_title' => 'login'));
  print $page->html;
}

?>
