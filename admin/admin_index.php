<?php include "includes/admin_header.php" ?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navbar.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome Admin
                        <small> <?php echo $_SESSION['username'] ?></small>
                    </h1>

                </div>
            </div>
            <!-- /.row -->


            <!-- row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <?php
                                $select_stmt = $db->prepare("SELECT count(*) as count FROM posts");    //sql select query
                                $select_stmt->execute();
                                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $number_of_posts = $row['count'];
                                }

                                ?>
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $number_of_posts; ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin_posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <?php
                                $select_stmt = $db->prepare("SELECT count(*) as count FROM comments"); //sql select query
                                $select_stmt->execute();
                                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $number_of_comments = $row['count'];
                                }
                                ?>
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $number_of_comments ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin_comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <?php
                                $select_stmt = $db->prepare("SELECT count(*) as count FROM user"); //sql select query
                                $select_stmt->execute();
                                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $number_of_users = $row['count'];
                                }
                                ?>
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $number_of_users ?></div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin_users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <?php
                                $select_stmt = $db->prepare("SELECT count(*) as count FROM categories"); //sql select query
                                $select_stmt->execute();
                                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $number_of_categories = $row['count'];
                                }
                                ?>
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $number_of_categories ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="category.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['bar']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Data', 'Total Number', 'not Displayed'],
                        <?php
                        // subscriber user selection
                        $select_stmt = $db->prepare("SELECT count(*) as count FROM user WHERE user_role='subscriber'"); //sql select query
                        $select_stmt->execute();
                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                            $number_of_sub = $row['count'];
                        }
                        // draft post selection
                        $select_stmt = $db->prepare("SELECT count(*) as count FROM posts WHERE post_status='draft'"); //sql select query
                        $select_stmt->execute();
                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                            $number_of_draft = $row['count'];
                        }
                        // unapproved comments selection
                        $select_stmt = $db->prepare("SELECT count(*) as count FROM comments WHERE comment_status='unapproved'"); //sql select query
                        $select_stmt->execute();
                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                            $number_of_unapproved = $row['count'];
                        }
                        $element_text = ['Active Posts', 'Comments', 'Users', 'Categories'];
                        $element_count = [$number_of_posts, $number_of_comments, $number_of_users, $number_of_categories];
                        $element_half = [$number_of_draft, $number_of_unapproved, $number_of_sub, 0];
                        for ($i = 0; $i < 4; $i++) {
                            echo "['{$element_text[$i]}'" . ", " . "{$element_count[$i]}".", ". "{$element_half[$i]}],";
                        }
                        ?>


                    ]);

                    var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
            </script>
            <div class="row">
                <div class="col-lg-12">
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->



    <?php include "includes/admin_footer.php"; ?>