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
    <title>User Profile Updation - Dashboard</title>

    <!-- Google Font & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <!-- Custom CSS -->
    <style>
      /* ==========================================================================
   RESET & BASE STYLES
   ========================================================================== */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family:
          "Nunito",
          -apple-system,
          BlinkMacSystemFont,
          "Segoe UI",
          Roboto,
          sans-serif;
        background-color: #f8f9fc;
        color: #5a5c69;
        font-size: 1rem;
        line-height: 1.5;
      }

      /* ==========================================================================
   LAYOUT STRUCTURE
   ========================================================================== */
      .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
        /* margin-left: 70px; */
      }

      /* SIDEBAR */
      .sidebar {
        width: 220px;
        background-color: #4e73df;
        background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        color: #ffffff;
        flex-shrink: 0;
        transition: all 0.3s ease;
        z-index: 100;
      }

      .sidebar-brand {
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
        gap: 10px;
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
        width: 100%;
      }

      .nav-link {
        display: flex;
        align-items: center;
        padding: 1.6rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 700;
        font-size: 1.5rem;
        gap: 12px;
        transition: color 0.2s ease;
      }

      .nav-link:hover,
      .nav-item.active .nav-link {
        color: #ffffff;
      }

      /* CONTENT AREA */
      .content-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 100vh;
        /* margin-left: 90px; */
      }

      /* TOPBAR */
      .topbar {
        height: 70px;
        background-color: #ffffff;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        position: relative;
      }

      .toggle-btn {
        display: none;
        background: none;
        border: none;
        font-size: 4rem;
        color: #4e73df;
        cursor: pointer;
      }

      .search-box {
        display: flex;
        align-items: center;
        background-color: #f8f9fc;
        border-radius: 0.35rem;
        overflow: hidden;
        max-width: 400px;
        width: 100%;
      }

      .search-box input {
        border: none;
        background: transparent;
        padding: 0.6rem 1rem;
        font-size: 1.5rem;
        outline: none;
        width: 100%;
        height: 60px;
        color: #6e707e;
      }

      .search-box button {
        background-color: #4e73df;
        border: none;
        color: #ffffff;
        padding: 0.6rem 1rem;
        cursor: pointer;
      }

      .search-box button:hover {
        background-color: #2e59d9;
      }

      /* USER PROFILE & DROPDOWN MENU */
      .user-dropdown-wrapper {
        position: relative;
      }

      .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.35rem;
        transition: background-color 0.2s ease;
      }

      .user-profile:hover {
        background-color: #f8f9fc;
      }

      .username {
        color: #858796;
        font-weight: 600;
        font-size: 1.5rem;
      }

      .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 1px solid #e3e6f0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fc;
        color: #b7b9cc;
      }

      .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        width: 180px;
        background-color: #ffffff;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        padding: 0.5rem 0;
        z-index: 1000;
      }

      .dropdown-menu.show {
        display: block;
      }

      .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.5rem 1rem;
        color: #3a3b45;
        text-decoration: none;
        font-size: 1.4rem;
        font-weight: 600;
        transition:
          background-color 0.2s ease,
          color 0.2s ease;
      }

      .dropdown-item i {
        color: #d1d3e2;
        width: 16px;
      }

      .dropdown-item:hover {
        background-color: #f8f9fc;
        color: #2e59d9;
      }

      .dropdown-item:hover i {
        color: #4e73df;
      }

      .dropdown-divider {
        height: 0;
        margin: 0.5rem 0;
        overflow: hidden;
        border-top: 1px solid #eaecf4;
      }

      /* ==========================================================================
   MAIN CONTENT & DASHBOARD CARDS
   ========================================================================== */
      .main-content {
        padding: 1.5rem;
        flex: 1;
        margin-left: 250px;
        margin-right: 250px;
      }

      .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        margin-left: 425px;
      }

      .page-heading h1 {
        font-size: 2rem;
        color: #5a5c69;
        font-weight: 400;
      }

      .btn-primary {
        background-color: #4e73df;
        color: #ffffff;
        border: none;
        padding: 0.5rem 0.8rem;
        border-radius: 0.35rem;
        font-size: 1.4rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      }

      .btn-primary:hover {
        background-color: #2e59d9;
      }

      .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
      }

      .card {
        background-color: #ffffff;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: 1px solid #e3e6f0;
        position: relative;
      }

      .card-border-primary {
        border-left: 0.25rem solid #4e73df;
      }
      .card-border-success {
        border-left: 0.25rem solid #1cc88a;
      }
      .card-border-info {
        border-left: 0.25rem solid #36b9cc;
      }
      .card-border-warning {
        border-left: 0.25rem solid #f6c23e;
      }

      .card-body {
        padding: 1.25rem;
      }

      .stat-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .stat-info {
        display: flex;
        flex-direction: column;
      }

      .stat-info.style-full {
        width: 100%;
        padding-right: 15px;
      }

      .stat-title {
        font-size: 1.4rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
        margin-bottom: 0.25rem;
      }

      .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #5a5c69;
      }

      .task-flex {
        display: flex;
        align-items: center;
        gap: 15px;
      }

      .progress-bar-sm {
        flex: 1;
        height: 8px;
        background-color: #eaecf4;
        border-radius: 10px;
        overflow: hidden;
      }

      .stat-icon {
        color: #dddfeb;
      }

      .card-header {
        padding: 0.75rem 1.25rem;
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .card-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4e73df;
      }

      /* ==========================================================================
   USER PROFILE DISPLAY CARD
   ========================================================================== */
      .profile-card {
        background-color: #ffffff;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.08);
        border: 1px solid #e3e6f0;
        display: grid;
        grid-template-columns: 1.2fr 1.5fr 1.5fr;
        min-height: 280px;
      }

      .profile-section {
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
      }

      .profile-section:not(:last-child) {
        border-right: 1px solid #eaecf4;
      }

      .profile-identity {
        align-items: center;
        justify-content: center;
        text-align: center;
      }

      .user-fullname {
        font-size: 2rem;
        font-weight: 700;
        color: #4e73df;
        margin-bottom: 0.25rem;
      }

      .user-email {
        font-size: 2rem;
        color: #b7b9cc;
      }

      .profile-details {
        justify-content: flex-start;
      }

      .profile-title {
        font-size: 3rem;
        font-weight: 400;
        color: #858796;
        margin-bottom: 1.75rem;
      }

      .info-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 4rem;
        margin-bottom: 1.1rem;
        color: #858796;
      }

      .info-row .label {
        font-weight: 600;
        color: #858796;
      }

      .info-row .value {
        color: #a0a3b3;
      }

      .profile-bio {
        justify-content: flex-start;
        padding-top: 2.5rem;
      }

      /* ==========================================================================
   USER PROFILE UPDATION FORM STYLES
   ========================================================================== */
      .form-main-title {
        font-size: 4rem;
        color: #5a5c69;
        font-weight: 400;
        margin-bottom: 0.5rem;
      }

      .update-card {
        max-width: 100%;
        background-color: #ffffff;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.08);
        border: 1px solid #e3e6f0;
        margin-bottom: 2rem;
      }

      .form-group {
        margin-bottom: 1.5rem;
      }

      .form-group label {
        display: block;
        font-size: 1.4rem;
        font-weight: 900;
        color: #6e707e;
        margin-bottom: 0.5rem;
      }

      .form-control {
        width: 100%;
        padding: 0.9rem 0.75rem;
        font-size: 1.4rem;
        font-family: "Nunito", sans-serif;
        color: #6e707e;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        transition:
          border-color 0.15s ease-in-out,
          box-shadow 0.15s ease-in-out;
        outline: none;
      }

      .form-control:focus {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
      }

      .textarea-control {
        resize: vertical;
      }

      .file-upload-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background-color: #fff;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        overflow: hidden;
        padding: 0.3rem;
      }

      .file-input {
        width: 40%;
        font-size: 1.4rem;
        color: #6e707e;
      }

      .file-input::file-selector-button {
        background-color: #eaecf4;
        color: #6e707e;
        border: 1px solid #d1d3e2;
        padding: 0.4rem 0.75rem;
        border-radius: 0.25rem;
        cursor: pointer;
        font-weight: 600;
        margin-right: 10px;
        transition: background-color 0.2s;
      }

      .file-input::file-selector-button:hover {
        background-color: #dddfeb;
      }

      .img-preview-box {
        width: 70px;
        height: 90px;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        background-color: #f8f9fc;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
        color: #b7b9cc;
        font-size: 1.5rem;
      }

      .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 2rem;
        border-top: 1px solid #e3e6f0;
        padding-top: 1rem;
      }

      .btn-cancel {
        background-color: transparent;
        color: #858796;
        border: none;
        padding: 0.5rem 1rem;
        font-size: 1.4rem;
        font-weight: 600;
        cursor: pointer;
      }

      .btn-cancel:hover {
        color: #5a5c69;
      }

      .btn-update {
        background-color: #1cc88a;
        color: #ffffff;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 0.35rem;
        font-size: 1.4rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: background-color 0.2s;
      }

      .btn-update:hover {
        background-color: #17a673;
      }

      /* ==========================================================================
   UTILITY CLASSES (Colors)
   ========================================================================== */
      .text-primary {
        color: #4e73df !important;
      }
      .text-success {
        color: #1cc88a !important;
      }
      .text-info {
        color: #36b9cc !important;
      }
      .text-warning {
        color: #f6c23e !important;
      }
      .text-danger {
        color: #e74a3b !important;
      }
      .text-white {
        color: #ffffff !important;
      }
      .text-dark {
        color: #5a5c69 !important;
      }
      .text-muted {
        color: #dddfeb !important;
      }

      .bg-primary {
        background-color: #4e73df !important;
      }
      .bg-success {
        background-color: #1cc88a !important;
      }
      .bg-info {
        background-color: #36b9cc !important;
      }
      .bg-warning {
        background-color: #f6c23e !important;
      }
      .bg-danger {
        background-color: #e74a3b !important;
      }
      .bg-secondary {
        background-color: #858796 !important;
      }
      .bg-light {
        background-color: #f8f9fc !important;
      }
      .bg-dark {
        background-color: #5a5c69 !important;
      }

      /* ==========================================================================
   MULTI-COLUMN FOOTER & SIMPLE FOOTER
   ========================================================================== */
      .footer {
        background-color: #ffffff;
        border-top: 1px solid #e3e6f0;
        margin-top: auto;
        color: #5a5c69;
      }

      .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2.5rem 1.5rem 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 2rem;
      }

      .footer-col h3 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #4e73df;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
        position: relative;
      }

      .footer-col h3::after {
        content: "";
        display: block;
        width: 40px;
        height: 2px;
        background-color: #4e73df;
        margin-top: 0.4rem;
        border-radius: 2px;
      }

      .footer-col p {
        font-size: 1.6rem;
        color: #858796;
        line-height: 1.6;
        margin-bottom: 0.5rem;
      }

      .footer-col p .icon {
        color: #4e73df;
        margin-right: 8px;
        width: 16px;
      }

      .footer-col ul {
        list-style: none;
        padding: 0;
        margin: 0;
      }

      .footer-col ul li {
        margin-bottom: 0.5rem;
      }

      .footer-col ul li a {
        color: #858796;
        text-decoration: none;
        font-size: 1.5rem;
        transition:
          color 0.2s ease,
          padding-left 0.2s ease;
      }

      .footer-col ul li a:hover {
        color: #4e73df;
        padding-left: 4px;
      }

      .footer-bottom {
        background-color: #f8f9fc;
        border-top: 1px solid #eaecf4;
        padding: 1rem 1.5rem;
        text-align: center;
        font-size: 1.5rem;
        color: #858796;
      }

      .footer-bottom a {
        color: #4e73df;
        text-decoration: none;
        font-weight: 700;
      }

      .footer-bottom a:hover {
        text-decoration: underline;
      }

      .footer-simple {
        background-color: #ffffff;
        padding: 1.25rem;
        text-align: center;
        font-size: 1.3rem;
        color: #858796;
        border-top: 1px solid #e3e6f0;
        margin-top: auto;
      }

      /* ==========================================================================
   RESPONSIVE DESIGN (Media Queries)
   ========================================================================== */
      @media (max-width: 992px) {
        .profile-card {
          grid-template-columns: 1fr;
        }

        .profile-section:not(:last-child) {
          border-right: none;
          border-bottom: 1px solid #eaecf4;
        }
      }

      @media (max-width: 768px) {
        .sidebar {
          position: fixed;
          top: 0;
          left: -220px;
          height: 100vh;
        }

        .sidebar.active {
          left: 0;
        }

        .toggle-btn {
          display: block;
        }

        .search-box {
          max-width: 200px;
        }
      }

      @media (max-width: 576px) {
        .search-box {
          display: none;
        }

        .footer-container {
          grid-template-columns: 1fr;
        }
      }
    </style>
  </head>
  <body>
    <!-- PAGE WRAPPER -->
    <div class="dashboard-wrapper">
      <!-- SIDEBAR -->
      <?php include('sidebar.php');?>

      <!-- CONTENT WRAPPER -->
      <div class="content-wrapper">
        <!-- TOP NAVBAR -->
       <?php include('topbar.php');?>

        <!-- MAIN CONTENT CONTAINER -->
        <main class="main-content">
          <!-- Page Heading -->
          <div class="page-heading">
           <?php
           $id = $_SESSION['u_id'];
           $query = "select * from all_users WHERE u_id = $id ";
           $obj = mysqli_query($con, $query);
           $row = mysqli_fetch_array($obj);
           
           ?>

            <h1 class="form-main-title">User Profile Updation</h1>
          </div>

          <!-- UPDATE FORM CARD -->
          <div class="card update-card">
            <div class="card-body">
              <form action="#" method="POST" enctype="multipart/form-data">
                <!-- Name -->
                <div class="form-group">
                  <label for="name">Name</label>
                  <input
                    type="text"
                    id="name"
                    name="u_name"
                    class="form-control"
                    value="<?php echo $row['u_name'];?>"
                  />
                </div>

                <!-- Email -->
                <div class="form-group">
                  <label for="email">Email</label>
                  <input
                    type="email"
                    id="email"
                    name="u_email"
                    class="form-control"
                    value="<?php echo $row['u_email'];?>"
                  />
                </div>

                <!-- Password -->
                <div class="form-group">
                  <label for="password">Password</label>
                  <input
                    type="password"
                    id="password"
                    name="u_pass"
                    class="form-control"
                    value="<?php echo $row['u_pass'];?>"
                  />
                </div>

                <!-- Picture -->
                <div class="form-group">
                  <label for="picture">Picture</label>
                  <div class="file-upload-wrapper">
                    <input
                      type="file"
                      id="picture"
                      name="u_pic"
                      class="file-input"
                    />
                    <img src="../img/<?php echo $row['u_pic'];?>" alt="" width="80" height="80" style="object-fit: cover; border-radius: 50%;">
                  </div>
                </div>

                <!-- DOB -->
                <div class="form-group">
                  <label for="dob">DOB</label>
                  <input
                    type="text"
                    id="dob"
                    name="u_dob"
                    class="form-control"
                    value="<?php echo $row['u_dob'];?>"
                  />
                </div>

                <!-- Country -->
                <div class="form-group">
                  <label for="country">Country</label>
                  <input
                    type="text"
                    id="country"
                    name="u_country"
                    value="<?php echo $row['u_country'];?>"
                    class="form-control"
                  />
                </div>

                <!-- City -->
                <div class="form-group">
                  <label for="city">City</label>
                  <input
                    type="text"
                    id="city"
                    name="u_city"
                     value="<?php echo $row['u_city'];?>"
                    class="form-control"
                  />
                </div>

                <!-- Website -->
                <div class="form-group">
                  <label for="website">Website</label>
                  <input
                    type="text"
                    id="website"
                    name="u_site"
                     value="<?php echo $row['u_site'];?>"
                    class="form-control"
                  />
                </div>

                <!-- Bio -->
                <div class="form-group">
                  <label for="bio">Bio</label>
                  <textarea
                    id="bio"
                    name="u_bio"
                    class="form-control textarea-control"
                    rows="6"
                  ><?php echo $row['u_bio'];?></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                  <button type="button" class="btn-cancel">Cancel</button>
                  <button type="submit" name="update" class="btn-update">Update</button>
                </div>
              </form>
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
        move_uploaded_file($u_pic_temp, "../img/$u_pic");

        $update_user = "update all_users set u_name='$u_name', u_email='$u_email', u_pass='$u_pass', u_pic='$u_pic', u_dob='$u_dob', u_country='$u_country', u_city='$u_city', u_site='$u_site', u_bio='$u_bio' where u_id='$id'";
        if (mysqli_query($con, $update_user)){

        echo "<script>window.open('user_profile.php', '_self')</script>";
        exit();
        }
                }
                
                ?>

            </div>
          </div>
        </main>
        <!-- /main-content -->

        <!-- SIMPLE FOOTER -->
        <footer class="footer-simple">
          <span>Copyright &copy; JafriCode.com 2022-23</span>
        </footer>
      </div>
      <!-- /content-wrapper -->
    </div>
    <!-- /dashboard-wrapper -->

    <!-- JavaScript for Sidebar & Dropdown -->
    <script>
      const sidebar = document.getElementById("sidebar");
      const toggleBtn = document.getElementById("sidebarToggle");
      toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("active");
      });

      const userProfileBtn = document.getElementById("userProfileBtn");
      const userDropdown = document.getElementById("userDropdown");

      userProfileBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        userDropdown.classList.toggle("show");
      });

      document.addEventListener("click", (e) => {
        if (
          !userDropdown.contains(e.target) &&
          !userProfileBtn.contains(e.target)
        ) {
          userDropdown.classList.remove("show");
        }
      });
    </script>
  </body>
</html>
<?php } ?>
