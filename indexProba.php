<?php

if (isset($_POST["submit"])) {
  $mydir = "myfiles/2021/";
  $fileCount = count($_FILES['file']['name']);
  $acceptedext = array("xml");
  for ($i = 0; $i < $fileCount; $i++) {
    $fileName = $_FILES['file']['name'][$i];
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    if (!in_array($extension, $acceptedext)) {
      echo " Wrong file " . $fileName;
    } else {
      if (!file_exists($mydir)) {
        mkdir($mydir, 0777, true);
        move_uploaded_file($_FILES['file']['tmp_name'][$i], $mydir . $fileName);
      } else {
        move_uploaded_file($_FILES['file']['tmp_name'][$i], $mydir . $fileName);
      }
      $files = scandir($mydir);
      print_r($files);
      echo "<br>";
      for ($i = 2; $i < count($files); $i++) {
        echo "File $i -> $files[$i] <br>";
      }
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="file[]" id="file" multiple>
    <input type="submit" name="submit" id="submit" value="submit">
  </form>
</body>

</html>