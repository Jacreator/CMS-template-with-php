<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <form action="search.php" method="post">
            <div class="well">
                <h4>Blog Search</h4>
                <div class="input-group">
                    <input type="text" name="txt_search" class=" form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default" name="submit_search" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
        </form>
        <!-- /.input-group -->
    </div>
</div>
<!-- Login Well -->
<div class="well">
    <form action="includes/login.php" method="post">
        <h4>Login</h4>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="txt_username" class=" form-control" placeholder="Enter Username">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="txt_password" class="form-control" placeholder="Enter Password">
            <span class="input-group-btn">
                <button class="btn btn-default" name="submit_login" type="submit">
                    Submit
                </button>
            </span>
        </div>
    </form>
    <!-- /.input-group -->
</div>




<!-- Blog Categories Well -->
<div class="well">
    <?php
                $select_stmt = $db->prepare("SELECT * FROM categories");    //sql select query
                $select_stmt->execute();
                
                ?>
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $catId = $row['cat_id'];
                    $title = $row['cat_title'];
                    echo "<li><a href='category.php?getCatId={$catId}'>{$title}</a></li>";
                }?> </ul>
        </div>

    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<?php include "widget.php" ?>