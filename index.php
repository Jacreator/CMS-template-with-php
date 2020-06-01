<?php include("codes/connection.php") ?>
<?php include("includes/header.php"); ?>
<!-- Navigation -->
<?php

include("includes/navbar.php"); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }
            if ($page == "" or $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * 5) - 5;
            }
            $endPage = 5;
            $select_stmt = $db->prepare("SELECT * FROM posts LIMIT :upage ',' :uendpage");    //sql select query
            $select_stmt->bindParam(":upage", $page_1);
            $select_stmt->bindParam(":uendpage", $endPage);
            $select_stmt->execute();

            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $post_id = $row['post_id'];
                $title = $row['post_title'];
                $author = $row['post_author'];
                $content = substr($row['post_content'], 0, 100);
                $date = $row['post_date'];
                $image = $row['post_image'];
                $post_status = $row['post_status'];

                // check for only published post for display
                if ($post_status == 'published') {
            ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?getId=<?php echo $post_id ?>"><?php echo $title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $date ?></p>
                    <hr>
                    <a href="post.php?getId=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $image ?>" alt=""></a>
                    <hr>
                    <p><?php echo $content ?></p>
                    <a class=" btn btn-primary" href="post.php?getId=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
            <?php
                }
            }
            ?>
            <!-- Pager -->

            <ul class="pager">
                <?php
                $select_stmt = $db->prepare("SELECT * FROM posts");    //sql select query
                $select_stmt->execute();
                $conut = $select_stmt->rowCount();
                $count = ceil($conut);
                for ($i = 1; $i <= $count; $i++) { ?>
                    <li>

                        <a href="index.php?page=<?php echo $i  ?>"><?php echo $i  ?></a>

                    </li>
                <?php } ?>
            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>
    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>