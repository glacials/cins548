<?php

/*
 * require means "include, but if there's a problem stop everything and quit"
 * _once means "if we already included it, don't do it again, just proceed"
 */
require_once 'db.php';

/* __autoload($class_name)
 * Automatically handles includes. When a class is used that PHP doesn't
 * recognize, it automatically calls this function to try to resolve the include
 * before it throws any errors. We don't ever need to call this ourselves.
 * See http://php.net/autoload
 */
function __autoload($class_name) {
  include 'classes/' . $class_name . '.php';
}

/* panic([$message])
 * Stop everything we're doing and quit with an optional message.
 */
function panic($message = false) {
  if($message)
    exit($message);
  else
    exit();
}

$template = new Template('index.html');
print $template->html;

?>
