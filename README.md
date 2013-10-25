# cins548

## To Do
1.	Check for XSS vulnerabilities etc.
2.	DONE---Create the ability to reset passwords via challenge question.
3.	DONE---Give users the ability to update and change ALL of their private information.
4.	DONE---Give admins the ability to edit all information that belongs to registered users.

## db.sql
	The default dump provided has these accounts already installed.

		bcarlsson@alpha.com	=> pw: 'password'
		akulkarni@alpha.com	=> pw: 'password'
		scory@alpha.com		=> pw: 'password'
		kluce@alpha.com		=> pw: 'password'

	The password-reset answer for all of these accounts is 'Team Alpha'

## Notices and error messages
To display a notice or an error message the next time a page is rendered to
this user, set the `$_SESSION['notice']` or `$_SESSION['error']` variables,
respectively. Like so:

    $_SESSION['error'] = 'Invalid user credentials, please try again.';

Next time a page is rendered (through index.php), the message will be prettily
displayed then removed from that user's session variables. The pages the message
displays via are `html/notice.html` and `html/error.html`.
