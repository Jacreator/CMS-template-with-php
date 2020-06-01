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
            if (isset($_GET['getCatId'])) {
                $categoryId = $_GET['getCatId'];
                $select_stmt = $db->prepare("SELECT * FROM posts WHERE post_category_id=:ucategory_id");    //sql select query
                $select_stmt->bindParam(":ucategory_id", $categoryId);
                $select_stmt->execute();
                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $post_id = $row['post_id'];
                    $title = $row['post_title'];
                    $author = $row['post_author'];
                    $content = substr($row['post_content'], 0, 100) ;
                    $date = $row['post_date'];
                    $image = $row['post_image'];

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
            <a href="post.php?getId=<?php echo $post_id ?>"><img class="img-responsive"
                    src="images/<?php echo $image ?>" alt=""></a>
            <hr>
            <p><?php echo $content ?></p>
            <a class=" btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            <?php
                }
            }
            ?>
            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>
    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>