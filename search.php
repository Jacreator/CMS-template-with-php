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
            if (isset($_POST['submit_search'])) {
                $search = $_POST['txt_search'];
                $search_statement = $db->prepare("SELECT * FROM posts WHERE post_tag LIKE ?");
                $search_statement->execute(array("%$search%"));
                if (!$search_statement) {
                    die("something wrong with query ". PDO::errorInfo());
                }
                $conut = $search_statement->rowCount();
                if($conut == 0){
                    echo "<h1>No Result</h1>";
                } else{
                    while ($row = $search_statement->fetch(PDO::FETCH_ASSOC)) {
                        $title = $row['post_title'];
                        $author = $row['post_author'];
                        $content = $row['post_content'];
                        $date = $row['post_date'];
                        $image = $row['post_image'];
            ?>
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="#"><?php echo $title ?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $author ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $date ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $image ?>" alt="">
            <hr>
            <p><?php echo $content ?></p>
            <a class=" btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            <?php
                    }
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