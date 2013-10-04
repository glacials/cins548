<?php
// define variables and set to empty values
$emailErr = $genderErr = $passwordErr = "";
$email = $gender = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (empty($_POST["email"]))
    {$emailErr = "Email is required";}
  else
    {
    $email = test_input($_POST["email"]);
    // check if e-mail address syntax is valid
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
      {
      $emailErr = "Invalid email format";
      }
    }

  if (empty($_POST["password"]))
    {$password = "";}
  else
    {
// commenting out the following for future development-----------   
<?php /*  need to modify string to enforce password requirements:   
    $password = test_input($_POST["password"]);
   // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$password))
      {
      $passwordErr = "Password does not meet requirements";
      }
    }
*/?>

  if (empty($_POST["gender"]))
    {$genderErr = "Gender is required";}
  else
    {$gender = test_input($_POST["gender"]);}
}
?>
