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

require_once 'autoload.php';
session_start();
$db = new Database;

# Still need to add checks to make sure users are doing things they
# are allowed to do. Logged in, admin etc.

# capturing data from POST...
$update_data = array('id' => $_POST['user_id'],
		     'username' => $_POST['email'],
		     'password_hash' => $_POST['password'],
		     'is_admin' => '', // We always want the value from the DB.
		     'address' => $_POST['address'],
		     'reset_question' => $_POST['question'],
		     'gender' => $_POST['gender'],
		     'reset_answer' => $_POST['answer']);

# Making sure user isn't being bad and changing hidden field in the form.
if ($_SESSION['user']->is_admin == 0 and ($_SESSION['user']->id != $_POST['id'])) {
	$_SESSION['error'] = 'There was a problem updating your account.';
	header('Location: ?alter_user');
} else {

$user = $db->get_user($update_data['id']);

# Handling if password is going to be updated.
if (!empty($_POST['password'])) {
	$update_data['password_hash'] = hash("sha256", $_POST['password'] . 'alPha548*3jasc');
}

# Handling if reset_answer is going to be updated.
if (!empty($_POST['answer'])) {
	$update_data['reset_answer'] = hash("sha256",$_POST['answer'] . 'alPha548*3jasc');
}

# We only want to update fields that are NOT blank.
foreach($update_data as $key => $value) {
	if (empty($update_data[$key])) {
		$update_data[$key] = $user->$key;
	}
}

# Creating our updated object.
$new_obj = new User($update_data['id'], $update_data['username'], $update_data['password_hash'], $update_data['is_admin'],
		    $update_data['gender'], date('Y-m-d H:i:s'), $update_data['reset_question'],$update_data['reset_answer'],
		    $update_data['address']);

# Check to see if username has already been taken, if they are updating it.
if(!empty($_POST['username']) and $db->username_exists($new_obj->username)) {
	$_SESSION['error'] = 'Email already exists. Sorry.';
	header('Location: ?alter_user');
} else {
	if($new_obj->save('update')) {
		// Update Session data if regular user updates their own account.
		if ($_SESSION['user']->is_admin == 0) {
			$_SESSION['user'] = $db->get_user($_SESSION['user']->id);
		} elseif($_SESSION['user']->id == $user->id) {
			$_SESSION['user'] = $db->get_user($_SESSION['user']->id);
		}
		$_SESSION['notice'] = 'Account successfully updated.';
		header('Location: ?user');
	} else {
		$_SESSION['error'] = 'There was a problem updating your account.';
		header('Location: ?user');
	}
}
}
?>
