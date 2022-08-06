<?php
if (isset($_GET['msg'])) {
  $msg = $_GET['msg'];
  echo '<div class="alert info">
        <span class="closebtn">&times;</span>  
        ' . $msg . '
      </div>';
  unset($_GET['msg']);
}
