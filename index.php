<?php

require_once 'autoload.php';

session_start();
$db = new Database;

$page_vars = array();

// Set the page's error message if it needs to be displayed, then clear it
if (isset($_SESSION['error'])) {
  $error = new Page('error.html', array('error' => $_SESSION['error']), false);
  $page_vars['error'] = $error->html;
  unset($_SESSION['error']);
}
if (isset($_SESSION['notice'])) {
  $notice = new Page('notice.html', array('notice' => $_SESSION['notice']), false);
  $page_vars['notice'] = $notice->html;
  unset($_SESSION['notice']);
}

if (isset($_SESSION['user'])) {
  $page_vars['rightnav_url_1'] = '?user';
  $page_vars['rightnav_text_1'] = $_SESSION['user']->username;
  $page_vars['rightnav_url_2'] = '?logout';
  $page_vars['rightnav_text_2'] = 'Log out';
} else {
  $page_vars['rightnav_url_1'] = '?login';
  $page_vars['rightnav_text_1'] = 'Log in';
  $page_vars['rightnav_url_2'] = '?signup';
  $page_vars['rightnav_text_2'] = 'Sign up';
}

if (isset($_GET['login'])) {
  if (isset($_POST['email']))
    require_once 'login.php';
  $page_vars['page_title'] = 'Log in';
  $page = new Page('login.html', $page_vars);
} elseif (isset($_GET['logout'])) {
  session_destroy();
  session_start();
  $_SESSION['notice'] = 'Successfully logged out.';
  header('Location: ?');
} elseif (isset($_GET['signup'])) {
  if (isset($_POST['email']))
    require_once 'signup.php';
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
  foreach ($db->get_all_products() as $product) {
    $product_page = new Page('product.html', array('product_name' => $some-name, 'product_desc' => $some-desc, ..etc));
    $product_list .= $product_page->html
  }
   */
  $page_vars['page_title'] = 'Browse items';
  $page_vars['product_list'] = $product_list;
  $page = new Page('browse.html', $page_vars);
} elseif (isset($_GET['search'])) {
  foreach (Product::get_products_like($_GET['search']) as $product) {
    $product_page = new Page('product.html', array('product_name'        => $product->name,
                                                   'product_description' => $product->description,
                                                   'product_image_url'   => $product->image_url,
                                                   'product_price'       => $product->price));
    $product_list .= $product_page->html;
  }
  $page_Vars['page_title'] = 'Search for \'' . $_GET['search'] . '\'';
  $page_vars['product_list'] = $product_list;
  $page = new Page('browse.html', $page_vars);
} elseif (isset($_GET['user'])) {
  $page_vars['page_title'] = 'User profile';
  $page_vars['user_email'] = $_SESSION['user']->email;
  $page = new Page('user.html', $page_vars);
} else {
  $page_vars['page_title'] = 'Home';
  $page = new Page('index.html', $page_vars);
}
print $page->html;

?>
