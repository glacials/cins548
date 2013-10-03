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
} elseif (isset($_GET['browse'])) {
  /*
   * Run each product through its Page, concatenate all that outputted HTML
   * together, then pass that to the browse.html Page via the product_list
   * variable.
   */
  /* todo: Doesn't yet work
  $product_list = '';
  foreach ($db->get_all_products()) {
    $product_page = new Page('product.html', array('product_name' => $some-name, 'product_desc' => $some-desc, ..etc));
    $product_list .= $product_page->html
  }
   */
  $page = new Page('browse.html', array('page_title' => 'Browse items', 'product_list' => $product_list));
} else {
  $page = new Page('index.html', array('page_title' => 'Home'));
}
print $page->html;

?>
