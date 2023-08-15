<?php 
require 'function.php';


; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/custom.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <div class="wrapper">
      <form method="post">
        <h1>Login</h1>
        <div class="input-box">
          <input type="text" name="email" placeholder="Username" required />
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Password" required />
          <i class="bx bxs-lock-alt"></i>
        </div>

        <div class="remember-forget">
          <label><input type="checkbox" />Remember Me</label>
          <a href="">Forgot Password</a>
        </div>

        <button  class="btn" name="login">Login</button>

        <div class="register-link">
          <p>Don't have an account? <a href="signup.php">Register</a></p>
        </div>
      </form>
    </div>
  </body>
</html>
