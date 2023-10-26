<?php
include "functions.php";
include "includes/header.php";

  // Check User Login
  if(isset($_SESSION['auth_id'])){
    header("Location: index.php", true, 301);
  }
?>
<style>
  body{
    background-color: black;
  }
</style>
<!-- Login form -->
<section>
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-4 offset-lg-4 dark:bg-gray-800 ">
        <div style="padding: 50px 0; border:1px solid #444; border-radius: 10px; padding: 20px">
          <form method="POST" action="functions.php"
            >
            <h1 class="text-center text-success mb-5">Sign in to our platform</h1>
            <!-- Show Error Message -->
            <?php
                if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
                  foreach ($_SESSION['errors'] as $error) {
                    preg_filter('/\s/', '', $error);
                    echo "<div class='alert alert-danger'>$error</div>";
                  }
                  unset($_SESSION['errors']); 
                }
              ?>

            <div class="form-group mt-3">
              <label for="email" class="form-label fw-bolder text-white">Email</label>
              <input name="email" placeholder="Enter Your Email" type="email" class="form-control" id="email"
                aria-describedby="email">
            </div>

            <div class="form-group mt-3">
              <label for="password" class="form-label fw-bolder text-white">Password</label>
              <input name="password" placeholder="Enter Your Password" type="password" class="form-control" id="password"
                aria-describedby="password">
            </div>

            <div class="form-group mt-3">
              <button name="login" type="submit" class="btn btn-success me-2">Login</button>
              <a href="registration.php" class="btn btn-link">create an account</a>
            </div>
            <div class="admin-info text-center text-white mt-3">
        <p>Admin Email: demoadmin@gmail.com</p>
        <p>Password: 12345678</p>
        </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Login form -->



<?php include __DIR__ ."/includes/footer.php" ?>