# cins548

## db.sql
All sample accounts in this database dump contain the password 'password'.

## Notices and error messages
To display a notice or an error message the next time a page is rendered to
this user, set the `$_SESSION['notice']` or `$_SESSION['error']` variables,
respectively. Like so:

    $_SESSION['error'] = 'Invalid user credentials, please try again.';

Next time a page is rendered (through index.php), the message will be prettily
displayed then removed from that user's session variables. The templates the
message runs through are `html/notice.html` and `html/error.html`.
