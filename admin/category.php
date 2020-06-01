<?php include "includes/admin_header.php";


?>
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
                        <small>Author</small>
                    </h1>
                    <div class="col-xs-6">
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
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="categories">Add Categories</label>
                                <input type="text" class="form-control" name="cat_title" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="submit_categories" value="Add">
                            </div>
                        </form>
                        <?php
                        // edit categories
                        editCategories();
                        ?>

                    </div>
                    <!-- table area -->
                    <div class=" col-xs-6">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // select all form categories
                                selectAllFromCategories();
                                ?>
                                <?php
                                // Deleting from categories
                                deleteFromCategories();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->



    <?php include "includes/admin_footer.php"; ?>