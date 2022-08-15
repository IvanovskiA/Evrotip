<?php
require_once("components/header.php");
?>
<div class="container h-350 w-350" style="margin-top: 200px;">
  <div class="header p-3 border-bottom">
    <span class="fw-bold poppins text-uppercase text-white">Upload Folders</span>
    <span class="btn btn-light btn-sm float-end d-none upload-button">Upload Folders </span>
  </div>
  <div class="content text-center mt-5">
    <input type="file" hidden name="file" id="file" webkitdirectory>
    <p class="text-white text-capitalize poppins">Choose a folder to upload</p>
    <button class="btn btn-light text-capitalize browse-button">Browse a folder</button>
  </div>

  <div class="progress mt-5 mx-5">
    <div class="progress-bar poppins bg-secondary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
  </div>
</div>
<?php
require_once("components/footer.php");
?>
<style scoped>
  footer {
    max-height: 80px;
    position: fixed;
    bottom: 0;
    width: 100%;
  }
</style>