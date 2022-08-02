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
