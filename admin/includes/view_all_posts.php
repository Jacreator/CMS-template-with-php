<?php
if (isset($errorMsg)) {
?>
    <div class="alert alert-danger">
        <strong>SORRY ! <?php echo $errorMsg; ?></strong>
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

<form action="" method="post">

    <table class="table table-hover table-bored">
        <div id="bulkOptionContainter" class="col-xs-4">
            <select class="form-control" name="bulk_option" id="">
                <option value="">Select One</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="send" class="btn btn-primary" value="Apply">
            <a href="admin_posts.php?source=add_post" class="btn btn-success">Add New Post</a>
        </div>
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckBoxes"> </th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th colspan="2" class="text-center">Opreation</th>
                <th>Live Preview</th>
            </tr>
        </thead>
        <tbody>
            <?php postSelect(); ?>
            <?php deletePost(); ?>
            <?php bulkOption(); ?>
        </tbody>
    </table>
</form>