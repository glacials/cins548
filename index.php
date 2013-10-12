<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

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

if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();
$page_vars['cart_size'] = count($_SESSION['cart']);

if (isset($_SESSION['user'])) {
  $page_vars['rightnav_url_1'] = '?user';
  $page_vars['rightnav_text_1'] = $_SESSION['user']->username;
  $page_vars['rightnav_url_2'] = '?logout';
  $page_vars['rightnav_text_2'] = 'Log out';
  if ($_SESSION['user']->is_admin) {
	  $page_vars['leftnav_url_1'] = '?admin';
	  $page_vars['leftnav_text_1'] = 'Admin';
  } else {
	  $page_vars['leftnav_url_1'] = '';
	  $page_vars['leftnav_text_1'] = '';
  }
} else {
  $page_vars['leftnav_url_1'] = '';
  $page_vars['leftnav_text_1'] = '';
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
  $product_list = '';
  foreach ($db->get_all_products() as $product) {
    $product_page = new Page('product.html', array('product_id'          => $product->id,
                                                   'product_name'        => $product->name,
                                                   'product_description' => $product->description,
                                                   'product_img'         => $product->image_url,
                                                   'product_price'       => $product->price), false);
    $product_list .= $product_page->html;
  }
  $page_vars['page_title'] = 'Browse items';
  $page_vars['product_list'] = $product_list;
  $page = new Page('browse.html', $page_vars);
} elseif (isset($_GET['search'])) {
  $product_list = '';
  foreach (Product::get_products_like($_GET['search']) as $product) {
    $product_page = new Page('product.html', array('product_name'        => $product->name,
                                                   'product_description' => $product->description,
                                                   'product_image_url'   => $product->image_url,
                                                   'product_price'       => $product->price), false);
    $product_list .= $product_page->html;
  }
  $page_vars['page_title'] = 'Search for \'' . $_GET['search'] . '\'';
  $page_vars['product_list'] = $product_list;
  $page = new Page('search.html', $page_vars);
} elseif (isset($_GET['user'])) {
	$purchase_list = '';
	foreach ($_SESSION['user']->purchases() as $purchase) {
		$item = $db->get_item($purchase->item_id);
		$purchase_page = new Page('purchase.html', array('purchase_id'	=> $purchase->purchase_id,
								 'item_name' 	=> $item->name,
								 'purchase_date'=> $purchase->date), false);
		$purchase_list .= $purchase_page->html;
	}
  $page_vars['page_title'] = 'User profile';
  $page_vars['purchase_list'] = $purchase_list;
  $page_vars['user_email'] = $_SESSION['user']->username;
  $page = new Page('user.html', $page_vars);
} elseif (isset($_GET['cart'])) {
  // Are we adding an item to the cart?
  // add_to_cart ---> product_id
  if (isset($_POST['product_id'])) {
      $product = $db->get_item($_POST['product_id']);
    if ($product) {
      $_SESSION['cart'][] = $product;
      $_SESSION['notice'] = 'Item successfully added to cart.';
      header('Location: ?cart');
    } else {
      $_SESSION['error'] = 'An error occurred while trying to add that item to your cart.';
      header('Location: ?browse');
    }
  }
  // Are we emptying the cart?
  if (isset($_POST['empty_cart'])) {
    unset($_SESSION['cart']);
    header('Location: ?cart');
  }
  if (isset($_POST['remove_item'])) {
    foreach ($_SESSION['cart'] as $key => $product)
      if ($product == $db->get_item($_POST['product_id']))
        unset($_SESSION['cart'][$key]);
    header('Location: ?cart');
  }
  $product_list = '';
  foreach ($_SESSION['cart'] as $product) {
    $product_page = new Page('product_in_cart.html', array('product_id'          => $product->id,
                                                           'product_name'        => $product->name,
                                                           'product_description' => $product->description,
                                                           'product_image_url'   => $product->image_url,
                                                           'product_price'       => $product->price), false);
    $product_list .= $product_page->html;
  }
  $page_vars['page_title'] = 'Shopping cart';
  $page_vars['product_list'] = $product_list;
  $page = new Page('cart.html', $page_vars);
} elseif (isset($_GET['admin']) and $_SESSION['user']->is_admin) {
	$user_list = '';
	$users = $db->get_all_users();
	foreach ($users as $user) {
		$user_page = new Page('user_item.html', array('user_id'	=> $user->id,
							      'username'=> $user->username,
							      'is_admin'=> $user->is_admin,
							      'gender'	=> $user->gender,
							      'updated' => $user->updated,
							      'reset_question' => $user->reset_question,
							      'address' => $user->address), false);
		$user_list .= $user_page->html;
	}
	$page_vars['user_list'] = $user_list;
	$page_vars['page_title'] = 'Admin Area';
	$page = new Page('admin.html', $page_vars);
  }else {
  $page_vars['page_title'] = 'Home';
  $page = new Page('index.html', $page_vars);
}
print $page->html;

?>
