<?php

/* __autoload($class_name)
 * Automatically handles includes. When a class is used that PHP doesn't
 * recognize, it automatically calls this function to try to resolve the include
 * before it throws any errors. We don't ever need to call this ourselves.
 * See http://php.net/autoload
 */
function __autoload($class_name) {
  include 'classes/' . $class_name . '.php';
}

?>
