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

function has_presence($value)
{
  return isset($value) && $value !== "";
}

function validationEmail($value)
{
  return filter_var($value, FILTER_VALIDATE_EMAIL);
}






function errors($error_array = array())
{
  global $error_array;
  if (!empty($error_array)) {
    global $errors;
    $errors .= '<div class="alert info">
      <span class="closebtn">&times;</span>';
    foreach ($error_array as $key => $value) {
      $errors .= ucfirst($key) . " $value <br>";
    }
    $errors .= '</div>';
  }
}
// }
