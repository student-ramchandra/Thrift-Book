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
    <title>All Users Record - Dashboard</title>
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
            font-size: 1.6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
        }

        .sidebar-brand i {
            font-size: 2rem;
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
            padding: 12px 25px;
            margin-top:30px;
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
            font-size: 1.7rem;
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

      /* Top Navbar */
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
        padding: 8px 12px;
        width: 100%;
        font-size: 1.4rem;
      }

      .search-box button {
        background-color: #3b82f6;
        color: #fff;
        border: none;
        padding: 19px 14px;
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
            font-weight: 600;
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
            font-size: 1.6rem;
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
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            list-style: none;
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
            z-index: 1000;
        }

        /* Show Dropdown on Hover or Active Class */
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
            transition: background-color 0.15s, color 0.15s;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: #2563eb;
        }

        .dropdown-item i {
            font-size: 1.3rem;
            width: 16px;
            text-align: center;
            color: #64748b;
        }

        .dropdown-item:hover i {
            color: #2563eb;
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
        flex-grow: 1;
      }

      .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
      }

      .content-header h1 {
        font-size: 2rem;
        color: #1e293b;
        font-weight: 600;
      }

      .btn-add {
        background-color: #3b82f6;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 1.6rem;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      }

      .btn-add:hover {
        background-color: #2563eb;
      }

      /* Card & Table Style */
      .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
      }

      .table-responsive {
        width: 100%;
        overflow-x: auto;
      }

      table {
        width: 105%;
        border-collapse: collapse;
        text-align: left;
        white-space: nowrap;
      }

      th {
        background-color: #fff;
        color: #475569;
        font-weight: 600;
        padding: 30px 20px;
        border-bottom: 2px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        font-size: 1.4rem;
      }

      td {
        padding: 30px 20px;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 1.4rem;
      }

      tr:hover {
        background-color: #f8fafc;
      }

      .action-icons {
        display: flex;
        gap: 12px;
      }

      .action-icons i {
        cursor: pointer;
        font-size: 1.6rem;
        transition: color 0.2s;
      }

      .action-icons .fa-pen-to-square {
        color: #3b82f6;
      }

      .action-icons .fa-pen-to-square:hover {
        color: #1d4ed8;
      }

      .action-icons .fa-trash-can {
        color: #ef4444;
      }

      .action-icons .fa-trash-can:hover {
        color: #dc2626;
      }

      /* Footer */
      footer {
        text-align: center;
        padding: 20px;
        color: #94a3b8;
        font-size: 1.4rem;
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
                width: 220px;
            }
            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
        <div class="content-header">
          <h1>All Users Record</h1>
          <a href="../register.php" class="btn-add">Add User</a>
        </div>

        <!-- Table Card -->
        <div class="card">
          <div class="table-responsive">
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Picture</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>Website</th>
                  <th>Bio</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>

                <?php
              $all_users = "select * from all_users";
              $objects = mysqli_query($con,$all_users );
              while($row = mysqli_fetch_array($objects)){

              

              ?>

                  <td><?php echo $row['u_name'];?></td>
                  <td><?php echo $row['u_email'];?></td>
                  <td>
                     <img src="../img/<?php echo $row['u_pic'];?>" alt="" width="70" height="50">
                  </td>
                  <td><?php echo $row['u_country'];?></td>
                  <td><?php echo $row['u_city'];?></td>
                  <td><?php echo $row['u_site'];?></td>
                  <td><?php echo $row['u_bio'];?></td>
                  <td>
                    <div class="action-icons">
                      <a href="edit_user_by_admin.php?edit=<?php echo $row['u_id'];?>"
                      title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i></a>
                      <a href="del_user.php?del=<?php echo $row['u_id'];?>"
                       title="Delete">
                      <i class="fa-solid fa-trash-can"> 
                      </i></a>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer>Copyright &copy; THRIFT-BOOK 2026-27</footer>
    </div>

    <!-- JavaScript for Toggle on Click (Works alongside Hover CSS) -->
    <script>
      const dropdownContainer = document.getElementById(
        "userDropdownContainer",
      );
      const userProfile = document.getElementById("userProfile");

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
    </script>
  </body>
</html>
<?php } ?>
