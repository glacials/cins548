<?php
// This php script will get data posted to it, like username, password,
// gender etc. It will then update that specific user in the database.
//
// Logic...
// Check to see if the user is logged-in
// If user is logged-in and user->is_admin
// 	-Get desired user from the database, create user object
// 	 with new data from the form and pre-existing data from
// 	 the user-object. --> merge them together. Save the new,
// 	 modified user_object with $user->save('update');
// ELSE
// 	Create new user-object with the new user data from the form
// 	and the pre-existing data from the user_object. ---> merge
// 	them together. Save the new, modified object with $user->save('update');
//
?>
