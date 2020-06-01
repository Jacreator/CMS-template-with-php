<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Fornt</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $select_stmt = $db->prepare("SELECT * FROM categories");    //sql select query
                $select_stmt->execute();
                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $title = $row['cat_title'];
                    echo "<li><a href='#'>{$title}</a></li>";
                }
                ?>
                <li><a href="admin/admin_index.php">Admin</a></li>
                <?php
                if (isset($_SESSION['role'])) {
                    if (isset($_GET['getId'])) {
                        $getId = $_GET['getId'];
                        echo "<li><a href='admin/admin_posts.php?source=edit_post&editpost={$getId}'>Edit Post</a></li>";
                    }
                }

                ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>