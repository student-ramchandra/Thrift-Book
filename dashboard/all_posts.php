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
    <title>Dashboard - Your Posts Record</title>
    <!-- FontAwesome for icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <!-- Custom CSS -->
    <style>
      /* --- Reset & Base Styles --- */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background-color: #f8f9fc;
        color: #5a5c69;
      }

      /* --- Layout Wrapper --- */
      .app-container {
        display: flex;
        min-height: 100vh;
      }

      /* --- Sidebar Styling --- */
      .sidebar {
        width: 250px;
        background-color: #4e73df;
        background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        color: #ffffff;
        flex-shrink: 0;
        min-height: 100vh;
        padding: 1rem 0;
      }

      .sidebar-brand {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        font-size: 1.9rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        text-transform: capitalize;
      }

      .sidebar-brand i {
        font-size: 1.9rem;
      }

      .sidebar-divider {
        border: 0;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin: 1rem 0;
      }

      .sidebar-nav {
        list-style: none;
      }

      .sidebar-nav .nav-item .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 30px 30px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 1.5rem;
        transition:
          color 0.2s ease,
          background 0.2s ease;
      }

      .sidebar-nav .nav-item .nav-link:hover,
      .sidebar-nav .nav-item.active .nav-link {
        color: #ffffff;
        font-weight: 600;
      }

      /* --- Main Content Layout --- */
      .main-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
      }

      /* --- Topbar Styling --- */
      .topbar {
        height: 90px;
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        position: relative;
        z-index: 10;
      }

      .toggle-btn {
        background: transparent;
        border: none;
        color: #4e73df;
        cursor: pointer;
        display: none; /* Hide on desktop by default */
      }

      .search-box {
        display: flex;
        align-items: center;
      }

      .search-box input {
        background-color: #f8f9fc;
        border: 1px solid #eaecf4;
        border-radius: 5px 0 0 5px;
        padding: 8px 12px;
        font-size: 1.4rem;
        outline: none;
        width: 300px;
        height: 60px;
      }

      .search-box button {
        height: 60px;
        background-color: #4e73df;
        border: 1px solid #4e73df;
        color: #ffffff;
        padding: 8px 14px;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        font-size: 1.3rem;
      }

      .search-box button:hover {
        background-color: #2e59d9;
      }

      /* --- User Dropdown --- */
      .user-dropdown-wrapper {
        position: relative;
      }

      .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
      }

      .user-profile .username {
        font-size: 1.5rem;
        color: #858796;
      }

      .user-profile .avatar img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e3e6f0;
      }

      .dropdown-menu {
        display: none; /* Can be toggled with JS or :hover */
        position: absolute;
        right: 0;
        top: 120%;
        background-color: #ffffff;
        min-width: 160px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border-radius: 5px;
        overflow: hidden;
      }

      .user-dropdown-wrapper:hover .dropdown-menu {
        display: block;
      }

      .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: #3a3b45;
        text-decoration: none;
        font-size: 1.5rem;
      }

      .dropdown-item:hover {
        background-color: #eaecf4;
      }

      .dropdown-divider {
        height: 1px;
        background-color: #eaecf4;
        margin: 5px 0;
      }

      /* --- Content Body --- */
      .content-body {
        padding: 2rem;
        flex-grow: 1;
      }

      .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
      }

      .content-header h2 {
        font-size: 2.5rem;
        font-weight: 400;
        color: #5a5c69;
      }

      .btn-create {
        background-color: #4e73df;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1.5rem;
        transition: background 0.2s ease;
      }

      .btn-create:hover {
        background-color: #2e59d9;
      }

      /* --- Table Card Styling --- */
      .table-card {
        background-color: #ffffff;
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        padding: 1.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
      }

      .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
      }

      .custom-table th,
      .custom-table td {
        padding: 30px 30px;
        border: 1px solid #e3e6f0;
        font-size: 1.4rem;
      }

      .custom-table th {
        color: #858796;
        font-weight: 600;
        background-color: #ffffff;
      }

      .custom-table td {
        color: #858796;
      }

      .post-img {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border: 1px solid #eaecf4;
        border-radius: 3px;
      }

      /* --- Action Icons --- */
      .action-icons {
        display: flex;
        gap: 12px;
        align-items: center;
      }

      .action-icons a {
        text-decoration: none;
        font-size: 1.8rem;
      }

      .text-primary {
        color: #4e73df;
      }
      .text-success {
        color: #1cc88a;
      }
      .text-danger {
        color: #e74a3b;
      }

      /* --- Footer --- */
      .footer {
        background-color: #ffffff;
        border-top: 1px solid #e3e6f0;
        text-align: center;
        padding: 1.2rem;
        font-size: 1.4rem;
        color: #858796;
      }
    </style>
  </head>
  <body>
    <div class="app-container">
      <!-- Sidebar -->
      <?php include('sidebar.php');?>
      <!-- Main Content Wrapper -->
      <div class="main-wrapper">
        <!-- Topbar Header -->
        <?php include('topbar.php');?>
        <!-- Page Main Content Area -->
        <main class="content-body">
          <div class="content-header">
            <h2> All Posts Record</h2>
            <a href="create_post.php" class="btn-create">Create Post</a>
          </div>

          <!-- Table Card Container -->
          <div class="table-card">
            <table class="custom-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Picture</th>
                  <th>Content</th>
                  <th>Creator</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>

                <?php
                $id = $_SESSION['u_id'];
                $all_posts = "select * from all_posts";
                $objects = mysqli_query($con, $all_posts);
                while($row = mysqli_fetch_array($objects)){
                  $p_id = $row['p_id'];
                  $p_title = $row['p_title'];
                  $p_description = $row['p_description'];
                  $p_content = $row['p_content'];
                  $p_pic = $row['p_pic'];
                  $p_user = $row['p_user'];

                  $user = "select * from all_users where u_id = $p_user";
                  $obj = mysqli_query($con, $user);
                  $row = mysqli_fetch_array($obj);
                
                ?>
                  <td><?php echo $p_title; ?></td>
                  <td><?php echo substr($p_description , 0, 20); ?></td>
                  <td>
                    <img src="../post_img/<?php echo $p_pic; ?>" width="50" height="50" alt="" class="post-img" />
                  </td>
                  <td><?php echo substr ($p_content , 0, 20); ?></td>
                  <td><?php echo $row['u_name']; ?></td>
                  <td class="action-icons">
                    <a href="blog_single_post.php?post_id=<?php echo $p_id?>" title="View"
                      ><i class="fa-solid fa-eye text-primary"></i
                    ></a>
                    <a href="edit_post.php?edit_post=<?php echo $p_id?>" title="Edit"
                      ><i class="fa-solid fa-pen-to-square text-success"></i
                    ></a>
                    <a href="del_post.php?del_post=<?php echo $p_id?>" title="Delete"
                      ><i class="fa-solid fa-trash text-danger"></i
                    ></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
          <p>Copyright © THRIFT-BOOK.com 2026-27</p>
        </footer>
      </div>
    </div>
  </body>
</html>
<?php } ?>
