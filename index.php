<?php
# host, username, pwd, db name
session_start();
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
    <title>CMS System</title>
    <style>
      /* General Reset */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #ffffff;
        color: #333333;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }

      /* Header & Navbar - Increased Font & Spacing */
      .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f8f9fa;
        padding: 18px 40px;
        border-bottom: 1px solid #e5e5e5;
        flex-wrap: wrap;
        gap: 15px;
      }

      .nav-brand {
        font-size: 35px;
        font-weight: bold;
        color: #333333;
      }
      .nav-links {
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
      }
      .nav-links a {
        text-decoration: none;
        color: #555555;
        font-size: 30px; /* Increased font size */
        font-weight: 500;
        transition: color 0.2s ease;
        padding-right: 60px;
      }

      .nav-links a:hover {
        color: #000000;
      }

      /* Main Content Area */
      .main-container {
        width: 100%;
        padding: 50px 80px;
      }
      .page-title {
        text-align: center;
        font-size: 48px; /* Larger Page Title */
        font-weight: 800;
        color: #333333;
        margin-bottom: 45px;
      }

      /* Blog Post Cards - Larger Box & Typography */
  .posts-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
    width: 100%;
    align-items: stretch;
}

  .card {
    width: 100%;
    min-width: 0;
    min-height: 620px;
    background-color: #ffffff;
    border: 1px solid #dcdcdc;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
    display: flex;
    flex-direction: column;
}

.card-image-wrapper {
    width: 100%;
    height: 400px;
    border-bottom: 1px solid #e0e0e0;
    overflow: hidden;
}

    .card-image {
      display:block;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

  .card-content {
    padding: 15px;
    flex: 1;
}

.card-title {
    font-size: 25px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #111111;
}

      .card-description {
        font-size: 20px; /* Larger description text */
        color: #555555;
        margin-bottom: 15px;
      }

      .card-author {
        font-size: 20px; /* Larger author text */
        color: #333333;
      }

      .card-author strong {
        color: #000000;
      }

      .card-footer {
        border-top: 1px solid #eeeeee;
        padding: 15px;
        text-align: center;
      }

      .read-more-btn {
        text-decoration: none;
        color: #1b6ec2;
        font-weight: bold;
        font-size: 23px; /* Larger button text */
      }

      .read-more-btn:hover {
        text-decoration: underline;
      }

      /* Footer Styling - Increased Font Sizes */
      .footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e5e5e5;
        padding: 60px 40px;
        margin-top: 80px;
      }

      .footer-container {
        width: 100%;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 50px; /* Gap between footer columns */
      }

      .footer-col {
        flex: 1;
        min-width: 250px;
      }

      .footer-col h3 {
        font-size: 35px; /* Increased heading size */
        font-weight: bold;
        color: #333333;
        margin-bottom: 18px;
        letter-spacing: 0.5px;
      }

      .footer-col p {
        font-size: 25px; /* Increased text size */
        color: #666666;
        line-height: 1.6;
        margin-bottom: 10px;
      }

      .footer-col ul {
        list-style: none;
      }

      .footer-col ul li {
        margin-bottom: 12px;
      }

      .footer-col ul li a {
        text-decoration: underline;
        color: #666666;
        font-size: 25px; /* Increased link size */
      }

      .footer-col ul li a:hover {
        color: #000000;
      }

      @media (max-width: 900px) {
    .posts-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 500px) {
    .posts-grid {
        grid-template-columns: 1fr;
    }
}
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <header class="navbar">
      <div class="nav-brand">CMS</div>
      <nav class="nav-links">
        <a href="#">Home</a>
        <a href="#">About us</a>
        <a href="#">Contact us</a>

        <?php
        if(isset($_SESSION['u_id'])){
        
        
        ?>
        <a href="logout.php">Logout</a>
        <a href="dashboard/dashboard.php">Dashboard</a>
        <?php }
        
        else{
        
        ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <?php } ?>
      </nav>
    </header>

    <!-- Main Content Area -->
    <main class="main-container">
      <h1 class="page-title">Blog Posts</h1>

      <div class="posts-grid">
      <!-- Blog Post Card -->
      <?php
      $query = "select * from all_posts";
      $objects = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($objects)){
      $p_id = $row['p_user'];
      $user = "select * from all_users where u_id= $p_id";
      $obj = mysqli_query($con, $user);
      $user = mysqli_fetch_array($obj);
     
    ?>
        <article class="card">
          <div class="card-image-wrapper">
            <a href="#">
            <img
              src="post_img/<?php echo $row['p_pic']?>"
              alt="Blog Post Image"
              class="card-image"/>
            </a>
          </div>
          <div class="card-content">
            <h2 class="card-title"><?php echo substr($row['p_title'], 0, 20);?></h2>
            <p class="card-description"><?php echo substr($row['p_description'], 0, 20);?></p>
            <p class="card-author">Posted By: <strong><?php echo $user['u_name']?></strong></p>
          </div>
          <div class="card-footer">
            <a href="dashboard/blog_single_post.php?post_id=<?php echo $row['p_id']?>" class="read-more-btn">READ MORE</a>
          </div>
        </article>
        <?php  } ?>
      </div>
    </main>

    <!-- Footer Area -->
    <footer class="footer">
      <div class="footer-container">
        <!-- Column 1: Company Info -->
        <div class="footer-col">
          <h3>THRIFT-BOOK.COM</h3>
          <p>
            Thrift-Book is the online old book Platform, you can learn study, and buy what you 
            like best from this  etc
          </p>
        </div>

        <!-- Column 2: Products -->
        <div class="footer-col">
          <h3>PRODUCTS</h3>
          <ul>
            <li><a href="#">Angular</a></li>
            <li><a href="#">React</a></li>
            <li><a href="#">Vue</a></li>
            <li><a href="#">Laravel</a></li>
          </ul>
        </div>

        <!-- Column 3: Useful Links -->
        <div class="footer-col">
          <h3>USEFUL LINKS</h3>
          <ul>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>

        <!-- Column 4: Contact -->
        <div class="footer-col">
          <h3>CONTACT</h3>
          <p>Kathmandu, KTM 10012, Nepal</p>
          <p>info@example.com</p>
          <p>+ 977-9874567489</p>
          <p>+ 977-9876560098</p>
        </div>
      </div>
    </footer>
  </body>
</html>
