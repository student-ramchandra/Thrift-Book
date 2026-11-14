<?php
            $id = $_SESSION['u_id'];
            $query = "select * from all_users where u_id = '$id' ";
            $obj = mysqli_query($con, $query);
            $row = mysqli_fetch_array($obj);
                 
            ?>

<header class="topbar">
        <button class="toggle-btn" id="sidebarToggle" aria-label="Toggle Navigation">
          <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Search Bar -->
        <div class="search-box">
          <input type="text" placeholder="Search for..." />
          <button type="button" aria-label="Search">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>

        <!-- User Profile Dropdown Container -->
        <div class="user-dropdown-wrapper">
          <div class="user-profile" id="userProfileBtn">
            <span class="username"><?php echo $row['u_name'];?></span>
            <div class="avatar">
                <img src="../img/<?php echo $row['u_pic'];?>" alt="User Profile Picture">
            </div>
        </div>

          <!-- Profile Dropdown Menu -->
          <div class="dropdown-menu" id="userDropdown">
            <a href="user_profile.php" class="dropdown-item">
              <i class="fa-solid fa-user"></i>
              <span>Profile</span>
            </a>
            <a href="user_profile_setting.php" class="dropdown-item">
              <i class="fa-solid fa-gear"></i>
              <span>Settings</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="../logout.php" class="dropdown-item text-danger">
              <i class="fa-solid fa-right-from-bracket"></i>
              <span>Logout</span>
            </a>
          </div>
        </div>
      </header>