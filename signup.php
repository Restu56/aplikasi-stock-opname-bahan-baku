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
            <form method="post" class="pure=form">
                <h1>Register</h1>
                <div class="input-box">
                    <input type="text" name="nama" placeholder="username" required />
                    <i class="bx bxs-user"></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="email" required />
                    <i class="bx bxs-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="Password" minlength="8"required />
                    <i class="bx bxs-lock"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"  minlength="8" required onkeyup="checkPasswordMatch()"/>
                    <i class="bx bxs-lock"></i>
                </div>
                <button  type="submit" class="btn" name="regis" class="pure-button pure-button-primary">Register</button>

                
                <div class="register-link">
                    <p>Have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
            <script>
                var password = document.getElementById("password"),
                confirm_password = document.getElementById("confirm_password");

                function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords tidak selaras!");
                } else {
                    confirm_password.setCustomValidity("");
                }
                }

                password.onchange = validatePassword;
                confirm_password.onkeyup = validatePassword;

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 4000);
            </script>
            
        </div>
  </body>
</html>
