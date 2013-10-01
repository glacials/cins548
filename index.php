<?php

require_once 'autoload.php';

/* panic([$message])
 * Stop everything we're doing and quit with an optional message.
 */
function panic($message = false) {
  if($message)
    exit($message);
  else
    exit();
}

$db = new Database;

// Testing the login stuff. The second argument replaces '{page_title}' in header.html.
$page = new Page('login.html', array('page_title' => 'login'));
print $page->html;

?>
