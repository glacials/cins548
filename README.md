# cins548

## To Do
1.	Create the ability to reset passwords via challenge question.
2.	DONE---Give users the ability to update and change ALL of their private information.
3.	DONE---Give admins the ability to edit all information that belongs to registered users.

## db.sql
MOST sample accounts in this database dump contain the password 'password'.
Each User object also contains two reset columns, question and answer.
	For the sample accounts contained in the DB dump, the reset question
	is encrypted with the same salt and algorithm as the passwords.
	The answers to the reset questions are 'greenish'.

## Notices and error messages
To display a notice or an error message the next time a page is rendered to
this user, set the `$_SESSION['notice']` or `$_SESSION['error']` variables,
respectively. Like so:

    $_SESSION['error'] = 'Invalid user credentials, please try again.';

Next time a page is rendered (through index.php), the message will be prettily
displayed then removed from that user's session variables. The templates the
message runs through are `html/notice.html` and `html/error.html`.
