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
    <title>Admin Dashboard</title>
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
        font-size: 1.4rem;
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
        padding-top:25px;
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
        font-size: 10rem;
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
        font-size: 1.4rem;
        outline: none;
        width: 100%;
        color: #6e707e;
      }

      .search-box button {
        background-color: #4e73df;
        height: 50px;
        border: none;
        color: #ffffff;
        padding: 0.6rem 1rem;
        cursor: pointer;
      }

      .search-box button:hover {
        background-color: #2e59d9;
      }

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
  transition: background-color 0.2s ease, color 0.2s ease;
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

      /* MAIN CONTAINER */
      .main-content {
        padding: 1.5rem;
        flex: 1;
      }

      .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
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
        font-size: 1.3rem;
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

      /* ==========================================================================
   CARDS & GRID COMPONENT
   ========================================================================== */
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
        font-size: 1.5rem;
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
        font-size: 2rem;
        font-weight: 700;
        color: #4e73df;
      }

      .dropdown-icon {
        color: #dddfeb;
        cursor: pointer;
      }

      /* ==========================================================================
   CHARTS & DUAL COLUMN LAYOUT
   ========================================================================== */
      .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
      }

      .chart-body {
        height: 320px;
        position: relative;
      }

      .dashboard-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
      }

      .column-left,
      .column-right {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
      }

      .progress-item {
        margin-bottom: 1rem;
      }

      .progress-labels {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.3rem;
      }

      .progress-bar {
        height: 1rem;
        background-color: #eaecf4;
        border-radius: 0.35rem;
        overflow: hidden;
      }

      .progress-fill {
        height: 100%;
      }

      .colors-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
      }

      .color-box {
        padding: 1.25rem;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      }

      .color-title {
        font-weight: 700;
        font-size: 1.5rem;
      }

      .color-code {
        font-size: 0.75rem;
        opacity: 0.8;
      }

      .illustration-card {
        text-align: center;
      }

      .illustration-placeholder {
        height: 160px;
        background-color: #eaecf4;
        border-radius: 0.35rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: #4e73df;
        margin-bottom: 1rem;
      }

      .illustration-card p {
        color: #858796;
        font-size: 1.4rem;
        margin-bottom: 1rem;
      }

      .link-arrow {
        color: #4e73df;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.4rem;
      }

      .link-arrow:hover {
        text-decoration: underline;
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
   MULTI-COLUMN FOOTER STYLES
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
        font-size: 1.8rem;
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
        font-size: 1.4rem;
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
        font-size: 1.4rem;
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
        font-size: 1.4rem;
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

      /* ==========================================================================
   RESPONSIVE DESIGN (Media Queries)
   ========================================================================== */
      @media (max-width: 992px) {
        .charts-grid {
          grid-template-columns: 1fr;
        }

        .dashboard-row {
          grid-template-columns: 1fr;
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

        .colors-grid {
          grid-template-columns: 1fr;
        }

        .footer-container {
          grid-template-columns: 1fr;
        }
      }
    </style>

    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <!-- Google Font & Font Awesome Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />

  <!-- Chart.js for interactive charts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        <!-- Page Heading + Generate Report Button -->
        <div class="page-heading">
          <h1>Dashboard</h1>
          <button class="btn-primary">
            <i class="fa-solid fa-download"></i> Generate Report
          </button>
        </div>

        <!-- TOP STAT CARDS GRID -->
        <div class="cards-grid">

          <!-- Earnings (Monthly) -->
          <div class="card card-border-primary">
            <div class="card-body stat-card">
              <div class="stat-info">
                <span class="stat-title text-primary">EARNINGS (MONTHLY)</span>
                <span class="stat-value">$40,000</span>
              </div>
              <div class="stat-icon text-muted">
                <i class="fa-solid fa-calendar fa-2x"></i>
              </div>
            </div>
          </div>

          <!-- Earnings (Annual) -->
          <div class="card card-border-success">
            <div class="card-body stat-card">
              <div class="stat-info">
                <span class="stat-title text-success">EARNINGS (ANNUAL)</span>
                <span class="stat-value">$215,000</span>
              </div>
              <div class="stat-icon text-muted">
                <i class="fa-solid fa-dollar-sign fa-2x"></i>
              </div>
            </div>
          </div>

          <!-- Tasks -->
          <div class="card card-border-info">
            <div class="card-body stat-card">
              <div class="stat-info style-full">
                <span class="stat-title text-info">TASKS</span>
                <div class="task-flex">
                  <span class="stat-value">50%</span>
                  <div class="progress-bar-sm">
                    <div class="progress-fill bg-info" style="width: 50%;"></div>
                  </div>
                </div>
              </div>
              <div class="stat-icon text-muted">
                <i class="fa-solid fa-clipboard-list fa-2x"></i>
              </div>
            </div>
          </div>

          <!-- Pending Requests -->
          <div class="card card-border-warning">
            <div class="card-body stat-card">
              <div class="stat-info">
                <span class="stat-title text-warning">PENDING REQUESTS</span>
                <span class="stat-value">18</span>
              </div>
              <div class="stat-icon text-muted">
                <i class="fa-solid fa-comments fa-2x"></i>
              </div>
            </div>
          </div>

        </div> <!-- /cards-grid -->

        <!-- CHARTS SECTION -->
        <div class="charts-grid">

          <!-- Earnings Overview (Line Chart) -->
          <div class="card">
            <div class="card-header">
              <h3>Earnings Overview</h3>
              <i class="fa-solid fa-ellipsis-vertical dropdown-icon"></i>
            </div>
            <div class="card-body chart-body">
              <canvas id="earningsChart"></canvas>
            </div>
          </div>

          <!-- Revenue Sources (Donut Chart) -->
          <div class="card">
            <div class="card-header">
              <h3>Revenue Sources</h3>
              <i class="fa-solid fa-ellipsis-vertical dropdown-icon"></i>
            </div>
            <div class="card-body chart-body donut-body">
              <canvas id="revenueChart"></canvas>
            </div>
          </div>

        </div> <!-- /charts-grid -->

        <!-- PROJECTS, COLOR SYSTEM & INFO SECTION -->
        <div class="dashboard-row">

          <!-- Left Column: Projects & Color Boxes -->
          <div class="column-left">

            <!-- Projects Card -->
            <div class="card">
              <div class="card-header">
                <h3>Projects</h3>
              </div>
              <div class="card-body">
                
                <div class="progress-item">
                  <div class="progress-labels">
                    <span>Server Migration</span>
                    <span>20%</span>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-danger" style="width: 20%;"></div>
                  </div>
                </div>

                <div class="progress-item">
                  <div class="progress-labels">
                    <span>Sales Tracking</span>
                    <span>40%</span>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-warning" style="width: 40%;"></div>
                  </div>
                </div>

                <div class="progress-item">
                  <div class="progress-labels">
                    <span>Customer Database</span>
                    <span>60%</span>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-primary" style="width: 60%;"></div>
                  </div>
                </div>

                <div class="progress-item">
                  <div class="progress-labels">
                    <span>Payout Details</span>
                    <span>80%</span>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-info" style="width: 80%;"></div>
                  </div>
                </div>

                <div class="progress-item">
                  <div class="progress-labels">
                    <span>Account Setup</span>
                    <span>Complete!</span>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-success" style="width: 100%;"></div>
                  </div>
                </div>

              </div>
            </div>

            <!-- Color Palette System Grid -->
            <div class="colors-grid">
              <div class="color-box bg-primary text-white">
                <div class="color-title">Primary</div>
                <div class="color-code">#4e73df</div>
              </div>
              <div class="color-box bg-success text-white">
                <div class="color-title">Success</div>
                <div class="color-code">#1cc88a</div>
              </div>
              <div class="color-box bg-info text-white">
                <div class="color-title">Info</div>
                <div class="color-code">#36b9cc</div>
              </div>
              <div class="color-box bg-warning text-white">
                <div class="color-title">Warning</div>
                <div class="color-code">#f6c23e</div>
              </div>
              <div class="color-box bg-danger text-white">
                <div class="color-title">Danger</div>
                <div class="color-code">#e74a3b</div>
              </div>
              <div class="color-box bg-secondary text-white">
                <div class="color-title">Secondary</div>
                <div class="color-code">#858796</div>
              </div>
              <div class="color-box bg-light text-dark">
                <div class="color-title">Light</div>
                <div class="color-code">#f8f9fc</div>
              </div>
              <div class="color-box bg-dark text-white">
                <div class="color-title">Dark</div>
                <div class="color-code">#5a5c69</div>
              </div>
            </div>

          </div> <!-- /column-left -->

          <!-- Right Column: Illustrations & Approach -->
          <div class="column-right">

            <!-- Illustrations Card -->
            <div class="card">
              <div class="card-header">
                <h3>Illustrations</h3>
              </div>
              <div class="card-body illustration-card">
                <div class="illustration-placeholder">
                  <i class="fa-solid fa-laptop-code"></i>
                </div>
                <p>
                  Add some quality, svg illustrations to your project courtesy of
                  <a href="#" target="_blank" rel="noopener">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!
                </p>
                <a href="#" class="link-arrow">Browse Illustrations on unDraw &rarr;</a>
              </div>
            </div>

            <!-- Development Approach Card -->
            <div class="card">
              <div class="card-header">
                <h3>Development Approach</h3>
              </div>
              <div class="card-body">
                <p>
                  SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.
                </p>
                <p style="margin-top: 15px;">
                  Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.
                </p>
              </div>
            </div>

          </div> <!-- /column-right -->

        </div> <!-- /dashboard-row -->

      </main> <!-- /main-content -->

      <!-- MULTI-COLUMN FOOTER AREA -->
      <footer class="footer">
        <div class="footer-container">
          <!-- Column 1: Company Info -->
          <div class="footer-col">
            <h3>JAFRICODE.COM</h3>
            <p>
              JafriCode is the educational Platform, you can learn HTML, CSS,
              Python, JAVA, PHP etc
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
            <p><i class="fa-solid fa-house icon"></i> New York, NY 10012, US</p>
            <p><i class="fa-solid fa-envelope icon"></i> info@example.com</p>
            <p><i class="fa-solid fa-phone icon"></i> + 01 234 567 88</p>
            <p><i class="fa-solid fa-print icon"></i> + 01 234 567 89</p>
          </div>
        </div>

        <!-- Bottom Copyright Banner -->
        <div class="footer-bottom">
          <span>&copy; 2026 Copyright: <a href="https://THRIFT-BOOK.com" target="_blank">THRIFT-BOOK.com</a></span>
        </div>
      </footer>

    </div> <!-- /content-wrapper -->

  </div> <!-- /dashboard-wrapper -->

  <!-- JavaScript for Sidebar, Dropdown & Charts Setup -->
  <script>
    // Sidebar toggle for smaller screens
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });

    // User Profile Dropdown Toggle
    const userProfileBtn = document.getElementById('userProfileBtn');
    const userDropdown = document.getElementById('userDropdown');

    userProfileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      userDropdown.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!userDropdown.contains(e.target) && !userProfileBtn.contains(e.target)) {
        userDropdown.classList.remove('show');
      }
    });

    // Earnings Overview Line Chart
    const ctxLine = document.getElementById('earningsChart').getContext('2d');
    new Chart(ctxLine, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Earnings',
          data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
          borderColor: '#4e73df',
          backgroundColor: 'rgba(78, 115, 223, 0.05)',
          fill: true,
          tension: 0.3,
          pointRadius: 4,
          pointBackgroundColor: '#4e73df',
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          x: { grid: { display: false } },
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) { return '$' + value.toLocaleString(); }
            }
          }
        }
      }
    });

    // Revenue Sources Donut Chart
    const ctxDonut = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxDonut, {
      type: 'doughnut',
      data: {
        labels: ['Direct', 'Social', 'Referral'],
        datasets: [{
          data: [55, 30, 15],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          borderWidth: 5,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '80%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: { usePointStyle: true, padding: 20 }
          }
        }
      }
    });
  </script>

</body>
</html>
<?php } ?>