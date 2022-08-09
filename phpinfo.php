<?php
// phpinfo();
?>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="d-flex flex-grow-1">
    <span class="w-100 d-lg-none d-block">
      <!-- hidden spacer to center brand on mobile -->
    </span>
    <a class="navbar-brand d-none d-lg-inline-block" href="#">
      Navbar 6
    </a>
    <a class="navbar-brand-two mx-auto d-lg-none d-inline-block" href="#">
      <img src="//via.placeholder.com/40?text=LOGO" alt="logo">
    </a>
    <div class="w-100 text-right">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
  <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">
    <ul class="navbar-nav ml-auto flex-nowrap">
      <li class="nav-item">
        <a href="#" class="nav-link m-2 menu-item nav-active">Our Solution</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link m-2 menu-item">How We Help</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link m-2 menu-item">Blog</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link m-2 menu-item">Contact</a>
      </li>
    </ul>
  </div>
</nav>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<style scoped>
  @media (min-width: 768px) {
    .navbar-brand.abs {
      position: absolute;
      width: auto;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
    }
  }

  nav {
    background-color: red;
  }
</style>