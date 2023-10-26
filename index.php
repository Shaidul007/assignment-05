<?php
include "functions.php";
include "includes/header.php";
?>
<style>
  body{
    background-color: black;
  }
</style>
<nav class="navbar navbar-expand-lg bg-success">
  <div class="container">
    <a class="navbar-brand" href="#">HOME</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
      aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>

    </div>
  </div>
</nav>

<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class=" text-success fw-semibold text-center mt-5">User Authentication and Role Management System</h1>
        
        <div class="buttton-section text-center my-5">
        <?php
        if(isset($_SESSION["auth_id"])){
          if($_SESSION["auth_role"] == "admin"){
            echo "<a href='dashboard.php' class='btn btn-danger btn-md me-3'>Dashboard</a>";
          }
          echo "<a href='?logout' class='btn btn-danger btn-md me-3'>Logout</a>";
        }else{
          echo "<a href='login.php' class='btn btn-danger btn-md me-3'>Login</a>";
          echo "<a href='registration.php' class='btn btn-danger btn-md me-3'>Registration</a>";
        }
      ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ ."/includes/footer.php" ?>