<?php
/*
 * This page will simply log users out. It will delete all session data related
 * to the user--> unset, and send them back to the homepage.
 */

session_start();

session_destroy();

header('Location: /index.php');
?>
