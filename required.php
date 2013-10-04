<?php
// define variables and set to empty values
$emailErr = $genderErr = $passwordErr = "";
$email = $gender  = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    if (empty($_POST["email"]))
    {$emailErr = "Email is required";}
  else
    {$email = test_input($_POST["email"]);}

  if (empty($_POST["password"]))
    {$password = "";}
  else
    {$password = test_input($_POST["password"]);}

  if (empty($_POST["gender"]))
    {$genderErr = "Gender is required";}
  else
    {$gender = test_input($_POST["gender"]);}
}
?>
