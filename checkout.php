<?php
// This file is included by index.php when the url is like '?checkout'

# Make sure visitor is logged-in
if (!isset($_SESSION['user'])) {
  $_SESSION['error'] = 'You must be logged in to checkout. Please login.';
  header('Location: ?login');
}
else {
  # Checking for an empty cart
  if (count($_SESSION['cart']) == 0) {
    $_SESSION['notice'] = 'Cart is empty. Please add items to your cart.';
    header('Location: ?browse');
  }
  else {
    if($_SESSION['user']->checkout($_SESSION['cart'])) {
      # Reset cart to empty
      $_SESSION['cart'] = array();
      $_SESSION['notice'] = 'Thank you. your order has been processed, and will dispatch soon.';
      header('Location: ?browse');
    }
  }
}

?>
