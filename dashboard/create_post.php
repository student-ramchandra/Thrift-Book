<?php
session_start();
if(!isset($_SESSION['u_id'])){
  echo "<script>window.open('../login.php','_self')</script>";
}else{
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
    <title>Create Post - Admin Dashboard</title>

    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <!-- Custom CSS -->
    <style>
      /* Google Fonts Import */
      @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap");

      /* Base Styles */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family:
          "Nunito",
          -apple-system,
          BlinkMacSystemFont,
          "Segoe UI",
          Roboto,
          sans-serif;
      }

      body {
        background-color: #f8f9fc;
        color: #5a5c69;
      }

      /* Layout Setup */
      .dashboard-container {
        display: flex;
        min-height: 100vh;
      }

      /* Sidebar Styling */
      .sidebar {
        width: 229px;
        background-color: #4e73df;
        background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        color: #ffffff;
        flex-shrink: 0;
        transition: all 0.3s ease;
      }

      .sidebar-brand {
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: 0.05rem;
        text-transform: uppercase;
        padding: 0 1rem;
      }

      .sidebar-brand i {
        font-size: 2rem;
      }

      .sidebar-divider {
        border: 0;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin: 0 1rem 1rem;
      }

      .sidebar-nav {
        list-style: none;
      }

      .nav-item {
        margin-bottom: 0.2rem;
      }

      .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 1.7rem 1.25rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: 600;
        transition:
          color 0.15s ease,
          background-color 0.15s ease;
      }

      .nav-link i {
        width: 16px;
        text-align: center;
      }

      .nav-link:hover,
      .nav-item.active .nav-link {
        color: #ffffff;
        font-weight: 700;
      }

      .nav-item.active .nav-link {
        background-color: rgba(255, 255, 255, 0.1);
      }

      /* Main Wrapper */
      .main-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
      }

      /* Topbar Header */
      .topbar {
        height: 100px;
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        z-index: 10;
      }

      .toggle-btn {
        background: none;
        border: none;
        font-size: 1.4rem;
        color: #4e73df;
        cursor: pointer;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      /* Search Box */
      .search-box {
        display: flex;
        align-items: center;
        max-width: 400px;
        width: 100%;

      }

      .search-box input {
        width: 100%;
        padding: 1rem 1rem;
        font-size: 1.4rem;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem 0 0 0.35rem;
        background-color: #f8f9fc;
        outline: none;
      }

      .search-box input:focus {
        background-color: #ffffff;
        border-color: #bac8f3;
      }

      .search-box button {
        background-color: #4e73df;
        color: #ffffff;
        border: 1px solid #4e73df;
        padding: 1.4rem 1.1rem;
        border-radius: 0 0.35rem 0.35rem 0;
        cursor: pointer;
        transition: background-color 0.15s ease;
      }

      .search-box button:hover {
        background-color: #2e59d9;
      }

      /* User Profile & Dropdown */
      .user-dropdown-wrapper {
        position: relative;
      }

      .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding: 0.5rem;
      }

      .username {
        font-size: 1.5rem;
        color: #858796;
        font-weight: 600;
      }

      .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #4e73df;
      }

      .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .dropdown-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        background-color: #ffffff;
        width: 180px;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: 1px solid #e3e6f0;
        display: none;
        flex-direction: column;
        padding: 0.5rem 0;
        z-index: 100;
      }

      .dropdown-menu.show {
        display: flex;
      }

      .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.7rem 1rem;
        color: #3a3b45;
        text-decoration: none;
        font-size: 1.5rem;
        transition: background-color 0.15s ease;
      }

      .dropdown-item:hover {
        background-color: #eaecf4;
      }

      .dropdown-item i {
        margin-right: 15px;
        width: 14px;
        color: #d1d3e2;
      }

      .dropdown-item.text-danger i {
        color: #e74a3b;
      }

      .dropdown-divider {
        height: 0;
        margin: 0.5rem 0;
        overflow: hidden;
        border-top: 1px solid #e3e6f0;
      }

      /* Main Content Area */
      .content-area {
        padding: 2rem;
        flex-grow: 1;
        margin-left: 90px;
      }

      .page-title {
        font-size: 2.9rem;
        margin-left: 400px;
        font-weight: 400;
        color: #858796;
        margin-bottom: 1.5rem;
      }

      /* Form Styles matching original screenshot */
      .post-form {
        display: flex;
        flex-direction: column;
        gap: 2rem;
      }

      .form-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }

      .form-group label {
        font-size: 1.6rem;
        color: #858796;
        font-weight: 800;
      }

      .form-control {
        width: 70%;
        padding: 1rem 1rem;
        font-size: 1.4rem;
        color: #6e707e;
        background-color: #ffffff;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        outline: none;
        transition:
          border-color 0.15s ease-in-out,
          box-shadow 0.15s ease-in-out;
      }

      .form-control:focus {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
      }

      .short-textarea {
        min-height: 100px;
        resize: vertical;
      }

      .tall-textarea {
        min-height: 250px;
        resize: vertical;
      }

      /* File Input Styling */
      .file-input {
        width: 70%;
        padding: 0.6rem;
        font-size: 1.4rem;
        color: #6e707e;
        background-color: #ffffff;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        cursor: pointer;
      }

      /* Submit Button */
      .btn-primary {
        background-color: #4e73df;
        color: #ffffff;
        border: none;
        padding: 0.6rem 1.5rem;
        font-size: 1.6rem;
        font-weight: 800;
        border-radius: 0.35rem;
        cursor: pointer;
        transition: background-color 0.15s ease;
      }

      .btn-primary:hover {
        background-color: #2e59d9;
      }

      /* Footer Styling */
      .footer {
        background-color: #ffffff;
        padding: 1.5rem;
        padding-left: 600px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #e3e6f0;
        margin-top: auto;
        font-size: 1.5rem;
        color: #858796;
      }

      .scroll-top-btn {
        background-color: #858796;
        color: #ffffff;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 0.35rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.15s ease;
      }

      .scroll-top-btn:hover {
        background-color: #5a5c69;
      }

      /* Responsive Styles */
      @media (max-width: 768px) {
        .sidebar {
          position: fixed;
          left: -224px;
          height: 100vh;
          z-index: 1000;
        }

        .sidebar.collapsed {
          left: 0;
        }

        .content-area {
          padding: 1rem;
        }

        .page-title {
          font-size: 1.8rem;
        }
      }
    </style>
  </head>
  <body>
    <div class="dashboard-container">
      <!-- Sidebar -->
      <?php include('sidebar.php');?>
      <!-- Main Content Wrapper -->
      <div class="main-wrapper">
        <!-- Topbar -->
         <?php include('topbar.php');?>

        <!-- Page Content -->
        <main class="content-area">
          <h1 class="page-title">Create post</h1>

          <!-- Create Post Form -->
          <form
            action=""
            method="POST"
            enctype="multipart/form-data"
            class="post-form"
          >
            <div class="form-group">
              <label for="postTitle">Title</label>
              <input
                type="text"
                id="postTitle"
                name="p_title"
                class="form-control"
                placeholder="Enter post title..."
                required
              />
            </div>

            <div class="form-group">
              <label for="postDesc">Post Description</label>
              <textarea
                id="postDesc"
                name="p_description"
                class="form-control short-textarea"
                placeholder="Enter post description..."
              ></textarea>
            </div>

            <div class="form-group">
              <label for="postContent">Post Content</label>
              <textarea
                id="postContent"
                name="p_content"
                class="form-control tall-textarea"
                placeholder="Enter post main content..."
              ></textarea>
            </div>

            <div class="form-group">
              <label for="postPicture">Picture</label>
              <div class="file-upload-wrapper">
                <input
                  type="file"
                  id="postPicture"
                  name="p_pic"
                  class="file-input"
                />
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" value="Publish" name="publish" class="btn-primary">Publish</button>
            </div>
          </form>
<?php
if(isset($_POST['publish'])){
  $p_title = $_POST['p_title'];
  $p_description = $_POST['p_description'];
  $p_content = $_POST['p_content'];
  $p_pic = $_FILES['p_pic']['name'];
  $p_pic_temp = $_FILES['p_pic']['tmp_name'];
  $date = date('Y-m-d H:i:s');
  $p_date = $date;
  $p_id = $_SESSION['u_id'];
  move_uploaded_file($p_pic_temp, "../post_img/$p_pic");
  $query = "INSERT INTO all_posts (p_title, p_description, p_content, p_pic, p_date, p_user) values ('$p_title', '$p_description', '$p_content', '$p_pic', '$p_date', '$p_id')";
  if(mysqli_query($con, $query)){

   $logged_user = $_SESSION['u_id'];
    $user = "select * from all_users where u_id= $logged_user";
    $obj = mysqli_query($con, $user);
    $row = mysqli_fetch_array($obj);
    
    if($row['u_is_admin']=='True') {
    echo "<script>window.open('all_posts.php', '_self')</script>";
  }else{
    echo "<script>window.open('your_posting.php', '_self')</script>";
  }
  }
}


?>

        </main>

        <!-- Footer -->
        <footer class="footer">
          <p>Copyright &copy; THRIFT-BOOK 2026-27</p>
          <button
            class="scroll-top-btn"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
          >
            <i class="fa-solid fa-angle-up"></i>
          </button>
        </footer>
      </div>
    </div>

    <!-- JavaScript for Profile Dropdown & Sidebar Toggle -->
    <script>
      const userProfileBtn = document.getElementById("userProfileBtn");
      const userDropdown = document.getElementById("userDropdown");
      const sidebarToggle = document.getElementById("sidebarToggle");
      const sidebar = document.getElementById("sidebar");

      // Toggle Dropdown Menu
      userProfileBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        userDropdown.classList.toggle("show");
      });

      // Close Dropdown Menu on Outside Click
      document.addEventListener("click", () => {
        if (userDropdown.classList.contains("show")) {
          userDropdown.classList.remove("show");
        }
      });

      // Toggle Sidebar Mobile/Collapse
      sidebarToggle.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
      });
    </script>
  </body>
</html>
<?php } ?>
