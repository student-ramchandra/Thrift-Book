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
    <title>User Profile - Dashboard</title>

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
        font-size: 2rem;
        line-height: 1.5;
      }

      /* ==========================================================================
   LAYOUT STRUCTURE
   ========================================================================== */
      .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
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
        padding-top: 27px;
      }

      .nav-link {
        display: flex;
        align-items: center;
        padding: 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 700;
        font-size: 1.4rem;
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
        min-width: 0;
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
        font-size: 1.25rem;
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
        font-size: 1.3rem;
        outline: none;
        width: 100%;
        color: #6e707e;
      }

      .search-box button {
        background-color: #4e73df;
        border: none;
        color: #ffffff;
        padding: 0.6rem 1rem;
        cursor: pointer;
        height: 55px;
      }

      .search-box button:hover {
        background-color: #2e59d9;
      }

      /* USER PROFILE & DROPDOWN */
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

      .dropdown-divider {
        height: 0;
        margin: 0.5rem 0;
        overflow: hidden;
        border-top: 1px solid #eaecf4;
      }

      .text-danger {
        color: #e74a3b !important;
      }

      /* MAIN CONTAINER & PROFILE CARD */
      .main-content {
        padding: 5rem 5rem;
        flex: 1;
      }

      .profile-card {
        background-color: #ffffff;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.08);
        border: 1px solid #e3e6f0;
        display: grid;
        grid-template-columns: 1.5fr 2fr 2fr;
        min-height: 280px;
      }

      .profile-section {
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
      }

      /* Vertical Divider lines between columns */
      .profile-section:not(:last-child) {
        border-right: 1px solid #eaecf4;
      }

      /* Column 1: Identity */
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
        font-size: 1.5rem;
        color: #b7b9cc;
      }

      /* Column 2: Profile Settings */
      .profile-details {
        justify-content: flex-start;
      }

      .profile-title {
        font-size: 2rem;
        font-weight: 400;
        color: #858796;
        margin-bottom: 1.75rem;
      }

      .info-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.4rem;
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

      /* Column 3: Bio */
      .profile-bio {
        justify-content: flex-start;
        padding-top: 2.5rem;
      }

      .info-row {
        font-size: 1.4rem;
      }

      /* FOOTER */
      .footer-simple {
        background-color: #ffffff;
        padding: 1.25rem;
        text-align: center;
        font-size: 1.3rem;
        color: #858796;
        border-top: 1px solid #e3e6f0;
        margin-top: auto;
      }

      /* RESPONSIVE DESIGN */
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
          <!-- USER PROFILE CARD -->
          <div class="profile-card">
            <?php
            $id = $_SESSION['u_id'];
            $query = "select * from all_users where u_id = '$id' ";
            $obj = mysqli_query($con, $query);
            $row = mysqli_fetch_array($obj);
                 
            ?>

            <!-- Section 1: User Identity -->
            <div class="profile-section profile-identity">
              <h2 class="user-fullname"><?php echo $row['u_name'];?></h2>
              <p class="user-email"><?php echo $row['u_email'];?></p>
            </div>

            <!-- Section 2: Profile Settings & Info -->
            <div class="profile-section profile-details">
              <h2 class="profile-title">User Information</h2>

              <div class="info-row">
                <span class="label">Country:</span>
                <span class="value"><?php echo $row['u_country'];?></span>
              </div>

              <div class="info-row">
                <span class="label">City:</span>
                <span class="value"><?php echo $row['u_city'];?></span>
              </div>

              <div class="info-row">
                <span class="label">Date of Birth :</span>
                <span class="value"><?php echo $row['u_dob'];?></span>
              </div>

              <div class="info-row">
                <span class="label">Website :</span>
                <span class="value"><?php echo $row['u_site'];?></span>
              </div>
            </div>

            <!-- Section 3: Bio -->
            <div class="profile-section profile-bio">
              <div class="info-row">
                <span class="label">Bio :</span>
                <span class="value"><?php echo $row['u_bio'];?></span>
              </div>
            </div>
          </div>
          <!-- /profile-card -->
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
