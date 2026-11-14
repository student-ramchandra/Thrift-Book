<aside class="sidebar" id="sidebar">
      <div class="sidebar-brand">
        <i class="fa-solid fa-laugh-wink"></i>
        <span>Dashboard</span>
      </div>

      <hr class="sidebar-divider" />

      <ul class="sidebar-nav">
        <li class="nav-item active">
          <a href="../index.php" class="nav-link">
            <i class="fa-solid fa-house"></i>
            <span>Home Page</span>
          </a>
        </li>
        <?php
        $logged_user = $_SESSION['u_id'];
    $user = "select * from all_users where u_id= $logged_user";
    $obj = mysqli_query($con, $user);
    $row = mysqli_fetch_array($obj);
    
    if($row['u_is_admin']=='True') {
        ?>
        <li class="nav-item">
          <a href="all_users.php" class="nav-link">
            <i class="fa-solid fa-user"></i>
            <span>All Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="all_posts.php" class="nav-link">
            <i class="fa-solid fa-folder"></i>
            <span>All Posting</span>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a href="your_posting.php" class="nav-link">
            <i class="fa-solid fa-file-pen"></i>
            <span>Your Posting</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="create_post.php" class="nav-link">
            <i class="fa-solid fa-plus-circle"></i>
            <span>Create Post</span>
          </a>
        </li>
      </ul>
    </aside>