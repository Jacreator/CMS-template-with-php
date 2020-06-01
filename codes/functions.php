<?php

require "connection.php";

// Inserting into categories
if (isset($_POST['submit_categories'])) {
    $cat_title = $_POST["cat_title"];
    if (empty($cat_title)) {
        $errorMsg = "Please Enter category";
    }
    try {
        $cat_title = filter_var($cat_title, FILTER_SANITIZE_STRING);
        if (!isset($errorMsg)) {
            $sql = $db->prepare("INSERT INTO categories(cat_title) VALUE (:utitle)");
            $sql->bindParam(":utitle", $cat_title);
            if ($sql->execute()) {
                $updateMsg = "Category Added";
            }
        }
    } catch (PDOException $error) {
        $error->getMessage();
    }
}

// update into categories
if (isset($_POST['submit_update'])) {
    $id = $_POST['cat_id'];
    $cat_title = $_POST['cat_title'];
    if (empty($cat_title)) {
        $errorMsg = "Please Enter category";
    }
    try {
        $cat_title = filter_var($cat_title, FILTER_SANITIZE_STRING);
        if (!isset($errorMsg)) {
            $update_stmt = $db->prepare('UPDATE categories SET cat_title=:title_up WHERE cat_id=:id');
            $update_stmt->bindParam(":title_up", $cat_title);
            $update_stmt->bindParam(":id", $id);
            if ($update_stmt->execute()) {
                $updateMsg = "Category Updated";
            }
        }
    } catch (PDOException $error) {
        $error->getMessage();
    }
}


// edit categories
function editCategories()
{
    global $db;
    if (isset($_REQUEST['edit_id'])) {
        $editCatId = $_REQUEST['edit_id'];
        $categoriesUpdate = $db->prepare("SELECT * FROM categories WHERE cat_id=:uidd");    //sql select query
        $categoriesUpdate->bindParam(":uidd", $editCatId);
        $categoriesUpdate->execute();
        while ($row = $categoriesUpdate->fetch(PDO::FETCH_ASSOC)) {
            $catId = $row['cat_id'];
            $title = $row['cat_title'];
?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="categories">Edit Categories</label>
                    <input type="text" class="form-control" name="cat_title" value="<?php echo $title ?>">
                    <input type="text" class="form-control hidden" name="cat_id" value="<?php echo $catId ?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="submit_update" value="Update">
                </div>
            </form>
        <?php
        }
    }
}

// select all from categories
function selectAllFromCategories()
{
    global $db;
    $selectCategories = $db->prepare("SELECT * FROM categories ORDER BY cat_id DESC");    //sql select query
    $selectCategories->execute();
    while ($row = $selectCategories->fetch(PDO::FETCH_ASSOC)) {
        $catId = $row['cat_id'];
        $title = $row['cat_title'];

        ?>
        <tr>
            <td>
                <?php echo $catId ?>
            </td>
            <td>
                <?php echo $title ?>
            </td>
            <td>
                <a href="?edit_id=<?php echo $catId; ?>" class=" btn btn-primary">Edit</a>
                <a href="?delete_id=<?php echo $catId; ?>" class=" btn btn-danger">Delete</a>
            </td>
        </tr>
    <?php
    }
}

// Delete Categories
function deleteFromCategories()
{
    global $db;
    if (isset($_REQUEST['delete_id'])) {
        $catId = $_REQUEST['delete_id'];
        try {
            $delete_stmt = $db->prepare('DELETE FROM categories WHERE cat_id =:id');
            $delete_stmt->bindParam(':id', $catId);
            if ($delete_stmt->execute()) {
                header("Location:category.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}

// post select
function postSelect()
{
    global $db;
    $selectPosts = $db->prepare("SELECT * FROM posts ORDER BY post_id DESC");    //sql select query
    $selectPosts->execute();
    while ($row = $selectPosts->fetch(PDO::FETCH_ASSOC)) {
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comment_count = $row['post_comment_count_id'];
        $post_status = $row['post_status'];
    ?>
        <tr>
            <td><input class="checkboxes" type="checkBox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
            <td><?php echo $post_id ?></td>
            <td><?php echo $post_author ?></td>
            <td><?php echo $post_title ?></td>
            <?php
            $selectCategories = $db->prepare("SELECT * FROM categories WHERE cat_id=:upost_id ORDER BY cat_id DESC"); //sql select query
            $selectCategories->bindParam(":upost_id", $post_category_id);
            $selectCategories->execute();
            while ($row = $selectCategories->fetch(PDO::FETCH_ASSOC)) {
                $catId = $row['cat_id'];
                $catTitle = $row['cat_title'];
            }
            ?>
            <td><?php echo $catTitle ?></td>
            <td><?php echo $post_status ?></td>
            <td><img src="../images/<?php echo $post_image ?>" alt="image" width="100"></td>
            <td><?php echo $post_tag ?></td>
            <td><?php echo $post_comment_count ?></td>
            <td><?php echo $post_date ?></td>
            <td> <a href="admin_posts.php?source=edit_post&editpost=<?php echo $post_id ?>" class="btn btn-primary">Edit</a> </td>
            <td> <a href="admin_posts.php?deletepost=<?php echo $post_id ?>" class="btn btn-danger pull-right">Delete</a></td>
            <td><a href="../post.php?getId=<?php echo $post_id ?>" class="btn btn-success">Live View</a></td>
        </tr>
    <?php }
}

// bulk Option Control
function bulkOption()
{
    global $db;
    if (isset($_POST['checkBoxArray'])) {
        foreach ($_POST['checkBoxArray'] as $postValueId) {
            $bulk_option = $_POST['bulk_option'];
            switch ($bulk_option) {
                case "published":
                    try {
                        $updatePublish = $db->prepare("UPDATE posts SET post_status=:ustatus WHERE post_id=:upostId");
                        $updatePublish->bindParam(":ustatus", $bulk_option);
                        $updatePublish->bindParam(":upostId", $postValueId);
                        if ($updatePublish->execute()) {
                            header("Location:admin_posts.php");
                        }
                    } catch (PDOException $error) {
                        $error->getMessage();
                    }
                    break;
                case "draft":
                    try {
                        $updateDraft = $db->prepare("UPDATE posts SET post_status=:ustatus WHERE post_id=:upostId");
                        $updateDraft->bindParam(":ustatus", $bulk_option);
                        $updateDraft->bindParam(":upostId", $postValueId);
                        if ($updateDraft->execute()) {
                            header("Location:admin_posts.php");
                        }
                    } catch (PDOException $error) {
                        $error->getMessage();
                    }
                    break;
                case "delete":
                    try {
                        $deleteStmt = $db->prepare('DELETE FROM posts WHERE post_id =:upostId');
                        $deleteStmt->bindParam(':upostId', $postValueId);
                        if ($deleteStmt->execute()) {
                            header("Location:admin_posts.php");
                        }
                    } catch (PDOException $error) {
                        $error->getMessage();
                    }
                    break;
            }
        }
    }
}

function deletePost()
{
    global $db;
    if (isset($_GET['deletepost'])) {
        $postId = $_GET['deletepost'];
        try {
            $deleteStmt = $db->prepare('DELETE FROM posts WHERE post_id =:id');
            $deleteStmt->bindParam(':id', $postId);
            if ($deleteStmt->execute()) {
                header("Location:admin_posts.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}

// Insert Post
function insertPost()
{
    global $db;
    if (isset($_POST['create_post'])) {
        $title = $_POST['txt_title']; // textbox name "txt_title"
        $categoryId = $_POST['txt_post_category']; //textbox name "txt_category_id"
        $author = $_POST['txt_author']; // textbox name "txt_author"
        $status = $_POST['txt_status']; // textbox name "txt_status"
        $tag = $_POST['txt_tag']; // textbox name "txt_tag"
        $content = $_POST['txt_content']; // textbox name "txt_content"
        $date = date('d:m:y');
        $image_file = $_FILES['txt_file']['name']; // get the name of a file and textbox name "text_file"
        $image_temp_location = $_FILES["txt_file"]["tmp_name"]; // temporay location for file
        $size = $_FILES['txt_file']['size'];
        $imageUploadPath = "../images/" . $image_file;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        // allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

        if (empty($image_file) and empty($image_temp_location)) {
            $errorMsg = "Pleas choose an Image";
        } else if ($size < 1000000) //check file size 1MB
        {
            if (in_array($fileType, $allowTypes)) {
                // image temp source and size 
                $image_temp_location = $_FILES['txt_file']['tmp_name'];
                $size = $_FILES['txt_file']['size'];
            } else $errorMsg = "File type not Supported";
        } else $errorMsg = "Your File To large Please Upload 1MB Size"; //error message file size not large than 5MB

        if (!isset($errorMsg)) {
            try {
                $compressedImage = compressImage($image_temp_location, $imageUploadPath, 50);
                if ($compressedImage) {
                    $insert_posts = $db->prepare("INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tag, post_status) VALUES(:ucategory, :utitle, :uauthor, :udate, :uimage, :ucontent, :utag, :ustatus)");
                    $insert_posts->bindParam(":ucategory", $categoryId);
                    $insert_posts->bindParam(":utitle", $title);
                    $insert_posts->bindParam(":uauthor", $author);
                    $insert_posts->bindParam(":udate", $date);
                    $insert_posts->bindParam(":uimage", $image_file);
                    $insert_posts->bindParam(":ucontent", $content);
                    $insert_posts->bindParam(":utag", $tag);
                    $insert_posts->bindParam(":ustatus", $status);
                    $results = $insert_posts->execute();
                    if ($results) {
                        $updateMsg = "Inserted successfully....";
                        echo $updateMsg;
                    }
                } else {
                    $updateMsg = "did not compress...";
                    echo $updateMsg;
                }
            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        }
    }
}

// insert Comments
function insertComment()
{
    global $db;
    if (isset($_POST['submit_comment'])) {
        $getPostId = $_GET['getId'];
        $author = $_POST['comment_author'];
        $email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];
        try {
            $author = filter_var($author, FILTER_SANITIZE_STRING);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $comment_content = filter_var($comment_content, FILTER_SANITIZE_STRING);
            $status = "unapproved";
            $date = date('d:m:y');
            if (!isset($errorMsg)) {
                $sql = $db->prepare("INSERT INTO comments(comment_post_id, comment_title, comment_author, comment_email, comment_content, comment_status, comment_date) VALUE (:upost_id, :utitle, :uauthor, :uemail, :ucontent, :ustatus, :udate)");
                $sql->bindParam(":upost_id", $getPostId);
                $sql->bindParam(":uauthor", $author);
                $sql->bindParam(":utitle", $title);
                $sql->bindParam(":uemail", $email);
                $sql->bindParam(":ucontent", $comment_content);
                $sql->bindParam(":ustatus", $status);
                $sql->bindParam(":udate", $date);
                if ($sql->execute()) {
                    $updateMsg = "Comment Added";
                    $updatePost = $db->prepare("UPDATE posts SET post_comment_count_id=post_comment_count_id + 1 WHERE post_id=:upostId");
                    $updatePost->bindParam(":upostId", $getPostId);
                    $updatePost->execute();
                }
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}


// comment Select
function commentSelect()
{
    global $db;
    $selectPosts = $db->prepare("SELECT * FROM comments ORDER BY comment_id DESC");    //sql select query
    $selectPosts->execute();
    while ($row = $selectPosts->fetch(PDO::FETCH_ASSOC)) {
        $comment_id = $row['comment_id'];
        $comment_title = $row['comment_title'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];

    ?>
        <tr>
            <td><?php echo $comment_post_id ?></td>
            <td><?php echo $comment_author ?></td>
            <td><?php echo $comment_email ?></td>
            <td><?php echo $comment_content ?></td>
            <td><?php echo $comment_status ?></td>

            <td><a href="../post.php?getId=<?php echo $comment_post_id ?>"><?php echo $comment_title ?></a>
            </td>

            <td><?php echo $comment_date ?>
            </td>
            <td><a href=" admin_comments.php?approvecomment=<?php echo $comment_id ?>" class="btn btn-primary">Approve</a>
            </td>
            <td><a href="admin_comments.php?unapprovecomment=<?php echo $comment_id ?>" class="btn btn-danger">Unapprove</a>
            </td>
            <td>
                <a href="admin_comments.php?deletecomment=<?php echo $comment_id ?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    <?php }
}


// delete comment
function deleteComment()
{
    global $db;
    if (isset($_GET['deletecomment'])) {
        $commentId = $_GET['deletecomment'];
        try {
            $deleteStmt = $db->prepare('DELETE FROM comments WHERE comment_id =:id');
            $deleteStmt->bindParam(':id', $commentId);
            if ($deleteStmt->execute()) {
                header("Location:admin_comments.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}

// approve Comment
function approveComment()
{
    global $db;
    if (isset($_GET['approvecomment'])) {
        $status = "approved";
        $commentId = $_GET['approvecomment'];
        try {
            $deleteStmt = $db->prepare('UPDATE comments SET comment_status=:ustatus WHERE comment_id =:id');
            $deleteStmt->bindParam(':id', $commentId);
            $deleteStmt->bindParam(':ustatus', $status);
            if ($deleteStmt->execute()) {
                header("Location:admin_comments.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}

// unapprove Comment
function unApproveComment()
{
    global $db;
    if (isset($_GET['unapprovecomment'])) {
        $status = "unapproved";
        $commentId = $_GET['unapprovecomment'];
        try {
            $changeStmt = $db->prepare('UPDATE comments SET comment_status=:ustatus WHERE comment_id =:id');
            $changeStmt->bindParam(':id', $commentId);
            $changeStmt->bindParam(':ustatus', $status);
            if ($changeStmt->execute()) {
                return $updateMsg = "Changes done...";
                header("Location:admin_comments.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}


// Select All user
function userSelect()
{
    global $db;
    $selectUser = $db->prepare("SELECT * FROM user ORDER BY user_id DESC");    //sql select query
    $selectUser->execute();
    $number = 1;
    while ($row = $selectUser->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    ?>
        <tr>
            <td><?php echo $number++ ?></td>
            <td><?php echo $username ?></td>
            <td><?php echo $user_firstname ?></td>
            <td><?php echo $user_lastname ?></td>
            <td><img src="../images/userImage/<?php echo $user_image ?>" alt="image" width="100" height="80"></td>
            <td><?php echo $user_role ?></td>
            <td><?php echo $user_email ?></td>
            <td>
                <a href="admin_users.php?admin=<?php echo $user_id ?>" class="btn btn-success">Admin</a>
                <a href="admin_users.php?unadmin=<?php echo $user_id ?>" class="btn btn-primary">Subscriber</a>
            </td>
            <td>
                <a href="admin_users.php?source=edit_user&edituser=<?php echo $user_id ?>" class="btn btn-warning">Edit</a>
                <a href="admin_users.php?deleteuser=<?php echo $user_id ?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
<?php }
}

// insert User
function insertUser()
{
    global $db;
}

// delete user
function deleteUser()
{
    global $db;
    if (isset($_GET['deleteuser'])) {
        $userId = $_GET['deleteuser'];
        try {
            $deleteStmt = $db->prepare('DELETE FROM user WHERE user_id =:id');
            $deleteStmt->bindParam(':id', $userId);
            if ($deleteStmt->execute()) {
                header("Location:admin_users.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}


// change user to admin
function changeToAdmin()
{
    global $db;
    if (isset($_GET['admin'])) {
        $status = "admin";
        $userId = $_GET['admin'];
        try {
            $changeStmt = $db->prepare('UPDATE user SET user_role=:ustatus WHERE user_id =:id');
            $changeStmt->bindParam(':id', $userId);
            $changeStmt->bindParam(':ustatus', $status);
            if ($changeStmt->execute()) {
                return $updateMsg = "Changes done...";
                header("Location:admin_users.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}

// change user to subscriber
function changeToSubscriber()
{
    global $db;
    if (isset($_GET['unadmin'])) {
        $status = "subscriber";
        $userId = $_GET['unadmin'];
        try {
            $changeStmt = $db->prepare('UPDATE user SET user_role=:ustatus WHERE user_id =:id');
            $changeStmt->bindParam(':id', $userId);
            $changeStmt->bindParam(':ustatus', $status);
            if ($changeStmt->execute()) {
                return $updateMsg = "Changes done...";
                header("Location:admin_users.php");
            }
        } catch (PDOException $error) {
            $error->getMessage();
        }
    }
}

// file compression function
function compressImage($source, $destination, $quality)
{
    // get image info
    $imageInfo = getimagesize($source);
    $mine = $imageInfo['mime'];

    // create a new image from file
    switch ($mine) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromgif($source);
            break;
    }
    // save image
    imagejpeg($image, $destination, $quality);

    // return compressed image
    return $destination;
}
