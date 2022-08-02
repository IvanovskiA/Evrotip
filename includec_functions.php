<?php
// Validation functions
$error_array = array();
function test_input($data)
{
  trim($data);
  htmlentities($data);
  stripslashes($data);
  return $data;
}

function validationEmail($email)
{
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
  } else {
    return false;
  }
}

function errors($error_array = array())
{
  global $error_array;
  if (!empty($error_array)) {
    global $errors;
    $errors .= "<div class='errorMessageDiv'>";
    foreach ($error_array as $key => $value) {
      $errors .= "*Field: " . ucfirst($key) . " $value <br>";
    }
    $errors .= "</div>";
    return $errors;
  }
}
