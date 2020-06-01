<?php
insertPost();
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
<form action="" method="Post" enctype="multipart/form-data">
    <!-- post title -->
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" id="exampleInput" placeholder="Enter title of the post"
            name="txt_title">
    </div>
    <!-- category id -->
    <div class="form-group">
        <div class="form-group">
            <div class="form-group">
                <select name="txt_post_category" id="" class="form-control">
                    <?php
            $selectCategories = $db->prepare("SELECT * FROM categories");    //sql select query
            $selectCategories->execute();
            while ($row = $selectCategories->fetch(PDO::FETCH_ASSOC)) {
                $catId = $row['cat_id'];
                $title = $row['cat_title'];
            ?>
                    <option value="<?php echo $catId ?>"><?php echo $title ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- post author -->
            <div class="form-group">
                <label for="author">Post Author</label>
                <input type="text" class="form-control" id="exampleInput" placeholder="Enter Author's name"
                    name="txt_author">
            </div>
            <!-- Post status -->
            <div class="form-group">
                <label for="status">Post Status</label>
                <input type="text" class="form-control" id="exampleInput" placeholder="Enter status of the post"
                    name="txt_status">
            </div>
            <!-- Post image -->
            <div class="form-group">
                <label for="title">Post Image</label>
                <input type="file" class="form-control" id="exampleInput" name="txt_file"><span style="color: red">image
                    must be
                    less
                    than
                    1 mp</span>
            </div>
            <!-- Post Tag -->
            <div class="form-group">
                <label for="tag">Post Tag</label>
                <input type="text" class="form-control" id="exampleInput" placeholder="Enter status of the post"
                    name="txt_tag">
            </div>
            <!-- Post Content -->
            <div class="form-group">
                <label for="content">Post Content</label>
                <textarea type="text" class="form-control" id="exampleInput" placeholder="Enter title of the post"
                    name="txt_content" rows="10"></textarea>
            </div>
            <!-- submit -->
            <div class="text-center form-group">
                <button type="submit" class="btn btn-primary" name="create_post" value="">Purblish Post</button>
            </div>
</form>