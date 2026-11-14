<?php
session_start();
# host, username, pwd, db name
$servername = "localhost";
$username = "root";
$user_pwd = "";
$db = "Thirft";
$con = mysqli_connect($servername, $username, $user_pwd, $db);

if(!$con){
  die("Connection is failed". mysqli_connect_error());
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family:
          -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
          "Helvetica Neue", Arial, sans-serif;
      }

      body {
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #333333;
        margin-right: 400px;
      }

      .login-wrapper {
        width: 100%;
        max-width: 400px;
        padding: 20px;
      }

      .form-group {
        margin-bottom: 40px;
        display: flex;
        flex-direction: column;
        width: 80vh;
      }

      .form-control {
        width: 100%;
        padding: 12px 14px;
        font-size: 30px;
        margin-top: 20px;
        background-color: #e8f0fe;
        border: 1px solid #d0d7de;
        border-radius: 4px;
        outline: none;
        transition:
          border-color 0.2s ease,
          background-color 0.2s ease;
      }

      .form-control:focus {
        background-color: #ffffff;
        border-color: #007bff;
      }

      .field-label {
        font-size: 25px;
        color: #555555;
        margin-top: 6px;
      }

      .row-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        font-size: 25px;
        width: 80vh;
      }

      .remember-me {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #333;
        cursor: pointer;
        user-select: none;
        padding-top: 30px;
      }

      .remember-me input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        margin-left: 100px;
      }

      .forgot-link {
        color: #007bff;
        text-decoration: none;
        margin-right: 150px;
        padding-top: 30px;
      }

      .forgot-link:hover {
        text-decoration: underline;
      }

      .btn-login {
        width: 80vh;
        height: 65px;
        padding: 12px;
        margin-top: 20px;
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        font-size: 25px;
        cursor: pointer;
        transition: background-color 0.2s ease;
      }

      .btn-login:hover {
        background-color: #0056b3;
      }

      .register-prompt {
        text-align: center;
        margin-top: 22px;
        font-size: 25px;
        color: #444;
        width: 80vh;
        margin-top: 40px;
      }

      .register-prompt a {
        color: #007bff;
        text-decoration: none;
      }

      .register-prompt a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div class="login-wrapper">
      <form action="#" method="POST">
        <!-- Email / Username Field -->
        <div class="form-group">
          <input
            type="text"
            name="u_email"
            class="form-control"
            value=""
            required
          />
          <span class="field-label">Email address</span>
        </div>

        <!-- Password Field -->
        <div class="form-group">
          <input
            type="password"
            name="u_pass"
            class="form-control"
            value=""
            required
          />
          <span class="field-label">Password</span>
        </div>

        <!-- Remember Me & Forgot Password Link -->
        <div class="row-options">
          <label class="remember-me">
            <input type="checkbox" name="remember" checked />
            Remember me
          </label>
          <a href="#" class="forgot-link">Forgot password?</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="login" class="btn-login">Login</button>

        <!-- Register Prompt Link -->
        <div class="register-prompt">
          Not a member? <a href="#">Register</a>
        </div>
      </form>

      <?php
      if(isset($_POST['login'])){
        $u_email = $_POST['u_email'];
        $u_pass = $_POST['u_pass'];
        $query = "select * from all_users where u_email = '$u_email' and u_pass = '$u_pass'";
        $user_obj = mysqli_query($con, $query);
        $row = mysqli_fetch_array($user_obj);
        $id = $row['u_id'];
        $num_of_row = mysqli_num_rows($user_obj);

        if($num_of_row == 1){
          $_SESSION['u_id'] = $id;
          echo "<script>window.open('index.php', '_self');</script>";
           }
        else{
          echo "<script>alert('Your email or password is incorrect, try again.');</script>";
        }
        }
      
      
      ?>
    </div>
  </body>
</html>
