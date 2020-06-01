<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="admin_index.php">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="../index.php">Home Page</a></li>


        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                <?php echo $_SESSION['firstname']. " " . $_SESSION['lastname'] ?> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <!-- dashboard -->
            <li>
                <a href="admin_index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <!-- post -->
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i
                        class="fa fa-fw fa-arrows-v"></i>
                    Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="admin_posts.php">View All Posts</a>
                    </li>
                    <li>
                        <a href="admin_posts.php?source=add_post">Add Posts</a>
                    </li>
                </ul>
            </li>
            <!-- category -->
            <li>
                <a href="category.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>
            <!-- comments -->
            <li>
                <a href="admin_comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <!-- user -->
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#user_dropdown"><i
                        class="fa fa-fw fa-arrows-v"></i>
                    Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="user_dropdown" class="collapse">
                    <li>
                        <a href="admin_users.php">View All user</a>
                    </li>
                    <li>
                        <a href="admin_users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>
            <!-- profile -->
            <li class="">
                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>