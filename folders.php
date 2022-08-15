<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES)) {
  $path = "uploadedFolders/";

  for ($i = 0; $i < count($_POST["folder"]); $i++) {
    $folder = dirname($_POST["folder"][$i]);
    // echo $folder;
    $full_path = $path . $folder;
    // echo $full_path;
    if (!file_exists($full_path)) {
      mkdir($full_path, 777, true);
    }
  }

  $array = (explode("/", $folder));
  $folderName = $array[0];
  // echo $path . $folderName;
  $dir = $path . $folderName;

  $folders = scandir($dir);

  print_r($d);
}
