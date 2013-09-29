<?php

/*
 * Establish a database connection. This file's permissions should be as
 * minimal as possible! If anyone gets read access to this file it's all over.
 */

$db = new mysqli('localhost', 'database_user_here', 'database_password_here', 'database_name_here');

?>
