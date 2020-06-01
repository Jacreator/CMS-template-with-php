<?php
if (isset($_GET['editpost'])) {
    $userId = $_GET['editpost'];
    $selectPosts = $db->prepare("SELECT * FROM posts WHERE post_id=:userid");    //sql select query
    $selectPosts->bindParam(":userid", $userId);
    $selectPosts->execute();
    while ($row = $selectPosts->fetch(PDO::FETCH_ASSOC)) {
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comment_count = $row['post_comment_count_id'];
        $post_status = $row['post_status'];
    }
}

if (isset($_POST['edit_post'])) {
    // fetch image for when image is not edited 
    $id = $_GET['editpost']; // get id from url 
    $select_stmt = $db->prepare('SELECT * FROM posts WHERE post_id=:id'); //sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    // End of fecht

    $title = $_POST['txt_title']; // textbox name "txt_title"
    $categoryId = $_POST['txt_post_category']; //textbox name "txt_post_category"
    $author = $_POST['txt_author']; // textbox name "txt_author"
    $status = $_POST['txt_status']; // textbox name "txt_status"
    $tag = $_POST['txt_tag']; // textbox name "txt_tag"
    $commentId = 4;
    $content = $_POST['txt_content']; // textbox name "txt_content"
    $date = date('d:m:y');

    $type        = $_FILES["txt_file"]["type"];
    $image_file = $_FILES['txt_file']['name']; // get the name of a file and textbox name "text_file"
    $image_temp_location = $_FILES["txt_file"]["tmp_name"]; // temporay location for file
    $size = $_FILES['txt_file']['size'];

    $path = "../images/" . $image_file;
    if ($image_file) {
        if ($type == "image/jpg" || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') //check file extension
        {
            if (!file_exists($path)) //check file not exist in your upload folder path
            {
                if ($size < 5000000) //check file size 5MB
                {
                    unlink("../images/" . $row['post_image']); //unlink function remove previous file
                    move_uploaded_file($image_temp_location, "../images/" . $image_file);     //move upload file temperory directory to your upload folder	
                } else {
                    $errorMsg = "Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
                }
            } else {
                $errorMsg = "File Already Exists...Check Upload Folder"; //error message file not exists your upload folder path
            }
        } else {
            $errorMsg = "Upload JPG, JPEG, PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
        }
    } else {
        $image_file = $row['post_image']; //if you not select new image than previous image sam it is it.
    }

    if (!isset($errorMsg)) {
        try {
            $update_posts = $db->prepare("UPDATE posts SET post_category_id=:ucategory, post_title=:utitle, post_author=:uauthor, post_date=:udate, post_image=:uimage, post_content=:ucontent, post_tag=:utag, post_comment_count_id=:ucount_id, post_status=:ustatus WHERE post_id=:userid");
            $update_posts->bindParam(":ucategory", $categoryId);
            $update_posts->bindParam(":utitle", $title);
            $update_posts->bindParam(":uauthor", $author);
            $update_posts->bindParam(":udate", $date);
            $update_posts->bindParam(":uimage", $image_file);
            $update_posts->bindParam(":ucontent", $content);
            $update_posts->bindParam(":utag", $tag);
            $update_posts->bindParam(":ucount_id", $commentId);
            $update_posts->bindParam(":ustatus", $status);
            $update_posts->bindParam(":userid", $userId);
            $results = $update_posts->execute();
            if ($results) {
                $updateMsg = "Inserted successfully....";
                header("refresh:2;");
            } else $errorMsg = "Could not Insert";
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }
}
?>
<form action="" method="Post" enctype="multipart/form-data">
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
    } ?>
    <!-- post title -->
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" id="exampleInput" value="<?php echo $post_title ?>" name="txt_title">
    </div>
    <!-- category id -->
    <div class="form-group">
        <label for="category">Categories</label>
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
        <input type="text" class="form-control" id="exampleInput" value="<?php echo $post_author ?>" name="txt_author">
    </div>
    <!-- Post status -->
    <div class="form-group">
        <label for="status">Post Status</label>
        <select name="txt_status" class="form-control">
            <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>
            <?php
            if ($post_status == "published") {
            ?>
                <option value="draft">Draft</option>
            <?php } else { ?>
                <option value="published">Published</option>
            <?php } ?>
        </select>
    </div>

    <!-- Post image -->
    <div class="row">
        <div class="form-group col-md-6">
            <label for="title">Post Image</label>
            <input type="file" class="form-control" id="exampleInput" name="txt_file">
            <span style="color: red">image must be less than 1 mp</span>
        </div>
        <div class="form-group col-md-6">
            <label for="pic">Present Pic</label>
            <img src="../images/<?php echo $post_image ?>" width="100" alt="image">
        </div>
    </div>
    <!-- Post Tag -->
    <div class="form-group">
        <label for="tag">Post Tag</label>
        <input type="text" class="form-control" id="exampleInput" value="<?php echo $post_tag ?> " name="txt_tag">
    </div>
    <!-- Post Content -->
    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea type="text" class="form-control" id="exampleInput" name="txt_content" rows="5"><?php echo $post_content ?></textarea>
    </div>
    <!-- submit -->
    <div class="text-center form-group">
        <button type="submit" class="btn btn-primary" name="edit_post" value="">Purblish Post</button>
    </div>
</form>