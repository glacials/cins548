<?php

require_once 'autoload.php';

$db = new Database;

// Testing the login stuff. The second argument replaces '{page_title}' in header.html.
$page = new Page('login.html', array('page_title' => 'login'));
print $page->html;

?>
