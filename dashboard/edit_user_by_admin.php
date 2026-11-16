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
    <title>CMS System - User Updation</title>
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- FontAwesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", sans-serif;
      }

      body {
        background-color: #f4f6f9;
        color: #333;
        display: flex;
        min-height: 100vh;
      }

      /* Sidebar Styles */
      .sidebar {
        width: 260px;
        background-color: #2b6cb0;
        color: #fff;
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        transition: all 0.3s ease;
        z-index: 100;
      }

      .sidebar-brand {
        padding: 20px;
        font-size: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
      }

      .sidebar-brand i {
        font-size: 2.1rem;
      }

      .sidebar-divider {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin: 0 15px 10px 15px;
      }

      .sidebar-nav {
        list-style: none;
        padding: 0;
        flex-grow: 1;
      }

      .sidebar-nav .nav-item {
        margin-bottom: 4px;
      }

      .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 30px 25px;
        margin-top: 15px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 1.5rem;
        transition: all 0.2s ease;
      }

      .sidebar-nav .nav-item.active .nav-link,
      .sidebar-nav .nav-link:hover {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
        border-left: 4px solid #fff;
        padding-left: 21px;
      }

      .sidebar-nav .nav-link i {
        font-size: 1.8rem;
        width: 20px;
        text-align: center;
      }

      /* Main Wrapper */
      .main-wrapper {
        margin-left: 260px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        transition: all 0.3s ease;
      }

      /* Topbar Styles */
      .topbar {
        background-color: #fff;
        padding: 12px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
        position: relative;
        z-index: 90;
      }

      .toggle-btn {
        background: transparent;
        border: none;
        font-size: 2rem;
        color: #64748b;
        cursor: pointer;
        display: none;
      }

      .search-box {
        display: flex;
        align-items: center;
        background-color: #f1f5f9;
        border-radius: 6px;
        overflow: hidden;
        width: 350px;
        border: 1px solid #cbd5e1;
      }

      .search-box input {
        border: none;
        outline: none;
        background: transparent;
        padding: 15px 12px;
        width: 100%;
        font-size: 1.4rem;
      }

      .search-box button {
        background-color: #3b82f6;
        color: #fff;
        border: none;
        padding: 21px 14px;
        cursor: pointer;
        transition: background 0.2s;
      }

      .search-box button:hover {
        background-color: #2563eb;
      }

      /* User Profile & Dropdown Wrapper */
      .user-dropdown-wrapper {
        position: relative;
      }

      .user-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 800;
        color: #475569;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 6px;
        transition: background-color 0.2s;
      }

      .user-profile:hover {
        background-color: #f1f5f9;
      }

      .username {
        font-size: 1.5rem;
        color: #334155;
        font-weight: 600;
      }

      .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e2e8f0;
      }

      .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      /* Dropdown Menu */
      .dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 210px;
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow:
          0 10px 15px -3px rgba(0, 0, 0, 0.1),
          0 4px 6px -2px rgba(0, 0, 0, 0.05);
        list-style: none;
        padding: 8px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s ease;
        z-index: 1000;
      }

      .user-dropdown-wrapper:hover .dropdown-menu,
      .user-dropdown-wrapper.active .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
      }

      .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 18px;
        color: #475569;
        text-decoration: none;
        font-size: 1.5rem;
        transition:
          background-color 0.15s,
          color 0.15s;
      }

      .dropdown-item:hover {
        background-color: #f8fafc;
        color: #2563eb;
      }

      .dropdown-item i {
        font-size: 1.4rem;
        width: 16px;
        text-align: center;
        color: #64748b;
      }

      .dropdown-item.text-danger {
        color: #ef4444;
      }

      .dropdown-item.text-danger i {
        color: #ef4444;
      }

      .dropdown-item.text-danger:hover {
        background-color: #fef2f2;
        color: #dc2626;
      }

      .dropdown-divider {
        height: 1px;
        background-color: #e2e8f0;
        margin: 6px 0;
      }

      /* Content Area */
      .content-container {
        padding: 30px;
        margin-left: 34px;
        flex-grow: 1;
      }

      .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
      }

      .content-header h1 {
        font-size: 2.3rem;
        color: #1e293b;
        font-weight: 600;
        margin-left: 700px;
      }

      /* Registration Form Container */
      .register-container {
        background-color: #ffffff;
        padding: 70px;
        /* margin-right: 400px; */
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        width: 70%;
        margin-left: 300px;
        border: 1px solid #e2e8f0;
      }

      /* Form Groups */
      .form-group {
        margin-bottom: 20px;
        margin-right: 200px;
        display: flex;
        flex-direction: column;
      }

      .form-group label {
        font-size: 1.4rem;
        font-weight: bold;
        color: #444444;
        margin-bottom: 8px;
      }

      .form-group input,
      .form-group textarea {
        padding: 12px 15px;
        font-size: 1.4rem;
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

      /* Checkbox Group */
      .form-checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        font-size: 1.3rem;
        color: #555555;
      }

      .form-checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
      }

      .form-checkbox-group label {
        cursor: pointer;
        font-weight: normal;
        margin-bottom: 0;
      }

      /* Divider line */
      .form-divider {
        border: none;
        border-top: 1px solid #e0e0e0;
        margin-bottom: 25px;
      }

      /* Button Actions */
      .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        align-items: center;
      }

      /* Update Button */
      .btn-update {
        background-color: #10b981;
        color: #ffffff;
        border: none;
        padding: 12px 30px;
        font-size: 1.5rem;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        transition:
          background-color 0.2s ease,
          transform 0.1s ease;
        text-align: center;
        text-decoration: none;
      }

      .btn-update:hover {
        background-color: #059669;
      }

      .btn-update:active {
        transform: scale(0.98);
      }

      /* Cancel Button */
      .btn-cancel {
        color: #666666;
        background-color: transparent;
        border: none;
        padding: 12px 20px;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s ease;
      }

      .btn-cancel:hover {
        color: #333333;
      }

      /* Footer */
      footer {
        text-align: center;
        padding: 20px;
        color: #94a3b8;
        font-size: 1.5rem;
        border-top: 1px solid #e2e8f0;
        background-color: #fff;
      }

      /* Responsive Design */
      @media (max-width: 992px) {
        .sidebar {
          width: 70px;
        }
        .sidebar .sidebar-brand span,
        .sidebar-nav .nav-link span,
        .sidebar-divider {
          display: none;
        }
        .main-wrapper {
          margin-left: 70px;
        }
        .sidebar-nav .nav-item.active .nav-link,
        .sidebar-nav .nav-link:hover {
          border-left: none;
          padding-left: 25px;
        }
        .toggle-btn {
          display: block;
        }
      }

      @media (max-width: 768px) {
        .topbar {
          padding: 12px 15px;
        }
        .search-box {
          width: 200px;
        }
        .content-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 15px;
        }
        .form-actions {
          flex-direction: column;
          align-items: stretch;
        }
      }
    </style>
  </head>
  <body>
    <!-- Sidebar -->
   <?php include('sidebar.php');?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
      <!-- Top Navbar -->
     <?php include('topbar.php');?>

      <!-- Content Container -->
      <div class="content-container">
      <?php
      if(isset($_GET['edit'])){
       $id = $_GET['edit'];
       $query = "select * from all_users where u_id = '$id' ";
       $obj = mysqli_query($con, $query);
       while($row = mysqli_fetch_array($obj)){
        $u_id = $row['u_id'];
        $u_name = $row['u_name'];
        $u_email = $row['u_email'];
        $u_pass = $row['u_pass'];
        $u_pic = $row['u_pic'];
        $u_dob = $row['u_dob'];
        $u_country = $row['u_country'];
        $u_city = $row['u_city'];
        $u_site = $row['u_site'];
        $u_bio = $row['u_bio'];

       
      ?>


        <div class="content-header">
          <h1>User update</h1>
        </div>

        <div class="register-container">
          <form action="#" method="POST" enctype="multipart/form-data">
            <!-- Name -->
            <div class="form-group">
              <label for="name">Name</label>
              <input
                type="text"
                id="name"
                name="u_name"
                value="<?php echo $u_name;?>"
                required
              />
            </div>

            <!-- Email -->
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                name="u_email"
                 value="<?php echo $u_email;?>"
                required
              />
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="pass">Password</label>
              <input
                type="password"
                id="pass"
                name="u_pass"
                value="<?php echo $u_pass;?>"
                required
              />
            </div>

            <!-- Picture -->
            <div class="form-group">
              <label for="picture">Picture</label>
              <input type="file" id="picture" name="u_pic" accept="image/*" />
              <image src="../img/<?php echo $u_pic; ?>" alt="" width="80" height="80">
            </div>

            <!-- Date of Birth (DOB) -->
            <div class="form-group">
              <label for="dob">Date of Birth</label>
              <input type="date" id="dob"  value="<?php echo $u_dob;?>" name="u_dob" />
            </div>

            <!-- Country -->
            <div class="form-group">
              <label for="country">Country</label>
              <input
                type="text"
                id="country"
                name="u_country"
                 value="<?php echo $u_country;?>"
              />
            </div>

            <!-- City -->
            <div class="form-group">
              <label for="city">City</label>
              <input
                type="text"
                id="city"
                name="u_city"
                value="<?php echo $u_city;?>"
              />
            </div>

            <!-- Site -->
            <div class="form-group">
              <label for="site">Website</label>
              <input
                type="url"
                id="site"
                name="u_site"
                 value="<?php echo $u_site;?>"
              />
            </div>

            <!-- Bio -->
            <div class="form-group">
              <label for="bio">Bio</label>
              <textarea
                id="bio"
                name="u_bio"
                placeholder="Write a short bio about yourself..."
              ><?php echo $u_bio;?></textarea>
            </div>

            <!-- Make this User as Admin Checkbox -->
            <div class="form-checkbox-group">
              <input type="checkbox" id="u_is_admin" name="u_is_admin" value="True" />
              <label for="u_is_admin">Make this User as Admin</label>
            </div>

            <!-- Divider Line -->
            <hr class="form-divider" />

            <!-- Cancel & Update Buttons -->
            <div class="form-actions">
              <a href="#" class="btn-cancel">Cancel</a>
              <button type="submit" name="update" class="btn-update">Update</button>
            </div>
          </form>
          <?php }} ?>
        </div>

        <?php
        if(isset($_POST['update'])){
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
          $u_is_admin = $_POST['u_is_admin'];

          move_uploaded_file($u_pic_temp, "../img/$u_pic");
          $update_user = "update all_users set u_name='$u_name', u_email='$u_email', u_pass='$u_pass', u_pic='$u_pic', u_dob='$u_dob', u_country='$u_country', u_city='$u_city', u_site='$u_site', u_bio='$u_bio', u_is_admin='$u_is_admin' where u_id='$id'";
          if (mysqli_query($con, $update_user)){
            
          echo "<script>window.open('all_users.php', '_self')</script>";
          exit();
          
          }
        }
        
        
        
        ?>
      </div>

      <!-- Footer -->
      <footer>Copyright &copy; THRIFT-BOOK.com 2026-27</footer>
    </div>

    <!-- JavaScript for Toggle on Click -->
    <script>
      const dropdownContainer = document.getElementById(
        "userDropdownContainer",
      );
      const userProfile = document.getElementById("userProfile");

      if (userProfile && dropdownContainer) {
        // Toggle dropdown on click
        userProfile.addEventListener("click", (e) => {
          e.stopPropagation();
          dropdownContainer.classList.toggle("active");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
          if (!dropdownContainer.contains(e.target)) {
            dropdownContainer.classList.remove("active");
          }
        });
      }
    </script>
  </body>
</html>
<?php } ?>
