<?php
// define variables and set to empty values
$email = $password = $gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["passworde"]);
  $gender = test_input($_POST["gender"]);
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
