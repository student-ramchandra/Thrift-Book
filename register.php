<?php
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
    <title>CMS System - Register</title>
    <style>
      /* General Reset */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f8f9fa;
        color: #333333;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 30px 15px;
      }

      /* Registration Form Container */
      .register-container {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 1000px;
        border: 3px solid #e0e0e0;
      }

      .form-title {
        font-size: 40px;
        font-weight: 800;
        color: #333333;
        margin-bottom: 30px;
        text-align: center;
      }

      /* Form Groups */
      .form-group {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
      }

      .form-group label {
        font-size: 20px;
        font-weight: bold;
        color: #444444;
        margin-bottom: 8px;
      }

      .form-group input,
      .form-group textarea {
        padding: 12px 15px;
        font-size: 20px;
        border: 1px solid #cccccc;
        border-radius: 4px;
        outline: none;
        transition: border-color 0.2s ease;
        background-color: #fdfdfd;
      }

      .form-group input:focus,
      .form-group textarea:focus {
        border-color: #1b6ec2;
        background-color: #ffffff;
      }

      .form-group input[type="file"] {
        padding: 8px;
        background-color: #ffffff;
      }

      .form-group textarea {
        resize: vertical;
        min-height: 120px;
      }

      /* Button Actions (Same Line) */
      .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        justify-content: flex-start;
      }

      /* Register Button (Green Box with Hover) */
      .btn-register {
        background-color: #28a745;
        color: #ffffff;
        border: none;
        padding: 12px 30px;
        font-size: 25px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        transition:
          background-color 0.2s ease,
          transform 0.1s ease;
        width: 250px;
        text-align: center;
        margin-left: 400px;
      }

      .btn-register:hover {
        background-color: #218838;
      }

      .btn-register:active {
        transform: scale(0.98);
      }

      /* Cancel Button */
      .btn-cancel {
        background-color: #dc3545;
        color: #ffffff;
        border: none;
        padding: 14px 20px;
        font-size: 25px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        transition:
          background-color 0.2s ease,
          transform 0.1s ease;
        width: 250px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
      }

      .btn-cancel:hover {
        background-color: #c82333;
      }

      .btn-cancel:active {
        transform: scale(0.98);
      }

      /* Responsive adjustments */
      @media (max-width: 500px) {
        .register-container {
          padding: 20px;
        }
        .form-actions {
          flex-direction: column;
        }
      }
    </style>
  </head>
  <body>
    <div class="register-container">
      <h2 class="form-title">Create Account</h2>

      <form action="#" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Name</label>
          <input
            type="text"
            id="name"
            name="u_name"
            placeholder="Enter your full name"
            required
          />
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="u_email"
            placeholder="Enter your email address"
            required
          />
        </div>

        
        <div class="form-group">
          <label for="pass">Password</label>
          <input
            type="password"
            id="pass"
            name="u_pass"
            placeholder="Enter your password"
            required
          />
        </div>

        
        <div class="form-group">
          <label for="picture">Picture</label>
          <input type="file" id="picture" name="u_pic" accept="image/*" />
        </div>

        
        <div class="form-group">
          <label for="dob">Date of Birth</label>
          <input type="date" id="dob" name="u_dob" />
        </div>

        
        <div class="form-group">
          <label for="country">Country</label>
          <input
            type="text"
            id="country"
            name="u_country"
            placeholder="Enter your country"
          />
        </div>

        
        <div class="form-group">
          <label for="city">City</label>
          <input
            type="text"
            id="city"
            name="u_city"
            placeholder="Enter your city"
          />
        </div>

        
        <div class="form-group">
          <label for="site">Website</label>
          <input
            type="url"
            id="site"
            name="u_site"
            placeholder="https://example.com"
          />
        </div>

        
        <div class="form-group">
          <label for="bio">Bio</label>
          <textarea
            id="bio"
            name="u_bio"
            placeholder="Write a short bio about yourself..."
          ></textarea>
        </div>

  <div class="form-actions">
  <input type="submit" name="register" value="Register" class="btn-register">
  <input type="button" value="Cancel" class="btn-cancel">
</div>
      </form>

      <?php
      if(isset($_POST['register'])){
        $u_name = $_POST['u_name'];
        $u_email = $_POST['u_email'];
        $u_pass = $_POST['u_pass'];
        $u_pic = $_FILES['u_pic']['name'];
        $u_pic_temp = $_FILES['u_pic']['tmp_name'];
        $u_dob = $_POST['u_dob'];
        $u_country = $_POST['u_country'];
        $u_city = $_POST['u_city'];
        $u_site = $_POST['u_site'];
        $u_bio = $_POST['u_bio'];

        move_uploaded_file($u_pic_temp, "img/$u_pic");
        $query = "INSERT INTO all_users (u_name, u_email, u_pass, u_pic, u_dob, u_country, u_city, u_site, u_bio) values ('$u_name', '$u_email', '$u_pass', '$u_pic', '$u_dob', '$u_country', '$u_city', '$u_site', '$u_bio')";
        if(mysqli_query($con, $query)){
          echo "<script>window.open('login.php', '_self')</script>";
        }
      }
      
      
      ?>
    </div>
  </body>
</html>
