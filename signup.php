<?php

// todo: insert submitted user into the database

$user = new User;

// todo: set all user information here

$user->save();

header('Location: /');

?>
