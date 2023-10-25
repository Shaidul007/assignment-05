<?php
include "functions.php";
include "includes/header.php";

  // Check User Login
  if(isset($_SESSION['auth_id'])){
    header("Location: index.php", true, 301);
  }
?>

<!-- Login form -->
<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div style="padding: 50px 0;" class="login-inner">
          <form method="POST" action="functions.php"
            style="background-color: #f1f1f1; border-radius: 10px; padding: 20px;">
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
              <label for="email" class="form-label fw-bolder">Email</label>
              <input name="email" placeholder="Enter Your Email" type="email" class="form-control" id="email"
                aria-describedby="email">
            </div>

            <div class="form-group mt-3">
              <label for="password" class="form-label fw-bolder">Password</label>
              <input name="password" placeholder="Enter Your Password" type="password" class="form-control" id="password"
                aria-describedby="password">
            </div>

            <div class="form-group mt-3">
              <button name="login" type="submit" class="btn btn-success me-2">Login</button>
              <a href="registration.php" class="btn btn-link">create an account</a>
            </div>


            <!-- Create User Account Details Page -->
            <div class="row mt-5">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Admin</th>
                    <th scope="col">Password</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>mainadmin@gmail.com</td>
                    <td>12345678</td>
                  </tr>
                  <tr>
                    <td>demouser@mail.com</td>
                    <td>12345678</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Login form -->



<?php include __DIR__ ."/includes/footer.php" ?>