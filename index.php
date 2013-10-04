<?php

require_once 'autoload.php';

session_start();
$db = new Database;

// Testing the login stuff. The second argument replaces '{page_title}' in header.html.
if (isset($_SESSION['user'])) {
  print 'Logged in! <a href="logout.php">Logout</a>';
}

$page_vars = array();

if (isset($_SESSION['user'])) {
  $page_vars['rightnav_url_1'] = '?user';
  $page_vars['rightnav_text_1'] = $_SESSION['user']->name;
  $page_vars['rightnav_url_2'] = '?logout';
  $page_vars['rightnav_text_2'] = 'Log out';
} else {
  $page_vars['rightnav_url_1'] = '?login';
  $page_vars['rightnav_text_1'] = 'Log in';
  $page_vars['rightnav_url_2'] = '?signup';
  $page_vars['rightnav_text_2'] = 'Sign up';
}

if (isset($_GET['login'])) {
  $page_vars['page_title'] = 'Log in';
  $page = new Page('login.html', $page_vars);
} elseif (isset($_GET['signup'])) {
  $page_vars['page_title'] = 'Sign up';
  $page = new Page('signup.html', $page_vars);
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
  $page_vars['page_title'] = 'Browse items';
  $page_vars['product_list'] = $product_list;
  $page = new Page('browse.html', $page_vars);
} else {
  $page_vars['page_title'] = 'Home';
  $page = new Page('index.html', $page_vars);
}
print $page->html;

?>
