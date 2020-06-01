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
            if (isset($_GET['getId'])) {
                $getPostId = $_GET['getId'];
                $select_stmt = $db->prepare("SELECT * FROM posts WHERE post_id=:upost_id");    //sql select query
                $select_stmt->bindParam(":upost_id", $getPostId);
                $select_stmt->execute();
                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $title = $row['post_title'];
                    $author = $row['post_author'];
                    $content = $row['post_content'];
                    $date = $row['post_date'];
                    $image = $row['post_image'];
                }
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
            <hr>
            <?php
            }
            insertComment();
            ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <?php
                if (isset($errorMsg)) {
                ?>
                <div class="alert alert-danger">
                    <strong>WRONG ! <?php echo $errorMsg; ?></strong>
                </div>
                <?php
                }
                if (isset($updateMsg)) {
                ?>
                <div class="alert alert-success">
                    <strong>UPDATE ! <?php echo $updateMsg; ?></strong>
                </div>
                <?php
                }
                ?>
                <form method="post">
                    <!-- Author comment -->
                    <div class="form-group">
                        <div>
                            <label for="Author">Author</label>

                            <input type="text" class="form-control" name="comment_author" id="">
                        </div>
                    </div>
                    <!-- email comment -->
                    <div class="form-group">
                        <div>
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="comment_email" id="">
                        </div>
                    </div>
                    <!-- comment content -->
                    <div class="form-group">
                        <label for="content">Your Comment</label>
                        <textarea class="form-control" name="comment_content" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->
            <?php
            $comment_stat = "approved";
            $selectComments = $db->prepare("SELECT * FROM comments WHERE comment_post_id=:upostId AND comment_status=:ustatus ORDER BY comment_id DESC");    //sql select query
            $selectComments->bindParam("upostId", $getPostId);
            $selectComments->bindParam("ustatus", $comment_stat);
            $selectComments->execute();
            while ($row = $selectComments->fetch(PDO::FETCH_ASSOC)) {
                $comment_date = $row['comment_date'];
                $comment_author = $row['comment_author'];
                $comment_content = $row['comment_content'];
            ?>
            <!-- comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author ?>
                        <small><?php echo $comment_date ?></small>
                    </h4>
                    <?php echo $comment_content ?>
                </div>
            </div>
            <?php } ?>
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