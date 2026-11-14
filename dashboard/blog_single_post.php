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
    <title>Blog Single Post</title>
    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
      }

      body {
        background-color: #ffffff;
        color: #333333;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }

      /* Navbar Styling */
      nav {
        display: flex;
        align-items: center;
        padding: 15px 40px;
        background-color: #ffffff;
        border-bottom: 1px solid #e5e5e5;
      }

      .logo {
        font-size: 30px;
        font-weight: bold;
        margin-right: 30px;
        color: #000000;
      }

      .nav-links {
        display: flex;
        gap: 50px;
        list-style: none;
      }

      .nav-links a {
        text-decoration: none;
        color: #666666;
        font-size: 25px;
      }

      .nav-links a:hover {
        color: #000000;
      }

      /* Main Content Styling */
      main {
        flex: 1;
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        padding: 40px 20px;
      }

      .post-title {
        font-size: 45px;
        font-weight: normal;
        margin-bottom: 15px;
        color: #111111;
      }

      .post-meta {
        font-size: 20px;
        color: #555555;
        margin-bottom: 25px;
      }

      .post-meta strong {
        color: #000000;
      }

      .post-heading {
        font-size: 40px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #222222;
      }

      .post-description{
        font-size:25px;
      }

      .post-image {
        width: 600px;
        height: 600px;
        object-fit: cover;
        border: 1px solid #cccccc;
        background-color: #f9f9f9;
        margin-bottom: 30px;
        display: block;
        margin-top:50px;
      }

      .post-paragraphs {
        margin-bottom: 30px;
      }

      .post-paragraphs p {
        font-size: 25px;
        line-height: 1.6;
        color: #555555;
        margin-bottom: 20px;
      }

      /* Footer Styling */
      footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 50px 20px 40px;
      }

      .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1.5fr;
        gap: 40px;
      }

      .footer-col h4 {
        font-size: 25px;
        font-weight: bold;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 20px;
        color: #495057;
      }

      .footer-col p {
        font-size: 20px;
        color: #6c757d;
        line-height: 1.6;
      }

      .footer-col ul {
        list-style: none;
      }

      .footer-col ul li {
        margin-bottom: 12px;
      }

      .footer-col ul li a {
        text-decoration: none;
        color: #6c757d;
        font-size: 20px;
      }

      .footer-col ul li a:hover {
        color: #212529;
      }

      .footer-col .contact-info p {
        margin-bottom: 12px;
      }

      @media (max-width: 768px) {
        .footer-container {
          grid-template-columns: 1fr;
          gap: 30px;
        }
      }
    </style>
  </head>
  <body>
    <!-- Header / Navbar -->
    <nav>
      <div class="logo">CMS</div>
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Contact us</a></li>
        <li><a href="#">Logout</a></li>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Register</a></li>
        <li><a href="#">Login</a></li>
      </ul>
    </nav>

    <!-- Main Content Area -->
    <main>
      <h1 class="post-title">
        <?php
        if(isset($_GET['post_id'])){
          $p_id = $_GET['post_id'];
          $query = "select * from all_posts where p_id = $p_id ";
          $obj = mysqli_query($con, $query);
          $row = mysqli_fetch_array($obj);
          $p_id = $row['p_id'];
          $p_title = $row['p_title'];
          $p_description = $row['p_description'];
          $p_content = $row['p_content'];
          $p_pic = $row['p_pic'];
          $p_date = $row['p_date'];
          $p_user = $row['p_user'];

          $user = "select * from all_users where u_id= $p_user";
          $obj = mysqli_query($con, $user);
          $row = mysqli_fetch_array($obj);

        }
        
        ?>
        <?php echo $p_title; ?></h1>
      <div class="post-meta">
        Published by: <strong><?php echo $row['u_name'];?></strong> on
        <strong><?php echo $p_date; ?></strong>
      </div>

      <h2 class="post-heading">Post Description</h2>
      <p class="post-description">
        <?php echo $p_description; ?>
      </p>

      <!-- Image placed BEFORE the description text -->
      <img
        src="../post_img/<?php echo $p_pic; ?>"
        alt="Post Image"
        class="post-image"
        width="500"
        height="400"
      />

      <div class="post-paragraphs">
        <p>
         <?php echo $p_content; ?>
        </p>
      </div>
    </main>

    <!-- Footer Area -->
    <footer>
      <div class="footer-container">
        <div class="footer-col">
          <h4>JAFRICODE.COM</h4>
          <p>
            JafriCode is the educational Platform, you can learn HTML, CSS,
            Python, JAVA, PHP etc
          </p>
        </div>

        <div class="footer-col">
          <h4>PRODUCTS</h4>
          <ul>
            <li><a href="#">Angular</a></li>
            <li><a href="#">React</a></li>
            <li><a href="#">Vue</a></li>
            <li><a href="#">Laravel</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>USEFUL LINKS</h4>
          <ul>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>CONTACT</h4>
          <div class="contact-info">
            <p>New York, NY 10012, US</p>
            <p>info@example.com</p>
            <p>+ 01 234 567 88</p>
            <p>+ 01 234 567 89</p>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>
