<?php
if (isset($_GET['edituser'])) {
    $userId = $_GET['edituser'];
    $selectUser = $db->prepare("SELECT * FROM user WHERE user_id=:userid");    //sql select query
    $selectUser->bindParam(":userid", $userId);
    $selectUser->execute();
    while ($row = $selectUser->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}

if (isset($_POST['edit_user'])) {
    // fetch image for when image is not edited 
    $id = $_GET['edituser']; // get id from url 
    $select_stmt = $db->prepare('SELECT * FROM user WHERE user_id=:id'); //sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    // end of fetch image 
    $fristname = $_POST['txt_firstname']; // textbox name "txt_firstname"
    $lastname = $_POST['txt_lastname']; //textbox name "txt_lastname"
    $username = $_POST['txt_username']; // textbox name "txt_username"
    $email = $_POST['txt_email']; // textbox name "txt_email"
    $password = $_POST['txt_password']; // textbox name "txt_password"
    $comfirm_password = $_POST['txt_comfirm_password']; // textbox name "txt_comfirm_password"
    $old_password = $_POST['txt_old_password']; // textbox name "txt_old_password"

    $type        = $_FILES["txt_file"]["type"];
    $image_file = $_FILES['txt_file']['name']; // get the name of a file and textbox name "text_file"
    $image_temp_location = $_FILES["txt_file"]["tmp_name"]; // temporay location for file
    $size = $_FILES['txt_file']['size'];

    /////////// Image area
    $path = "../images/userImage/" . $image_file; //set upload folder path
    if ($image_file) {
        if ($type == "image/jpg" || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') //check file extension
        {
            if (!file_exists($path)) //check file not exist in your upload folder path
            {
                if ($size < 5000000) //check file size 5MB
                {
                    unlink($directory . $row['user_image']); //unlink function remove previous file
                    move_uploaded_file($image_temp_location, "../images/userImage/" . $image_file);    //move upload file temperory directory to your upload folder	
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
        $image_file = $row['user_image']; //if you not select new image than previous image sam it is it.
    }

    ////////////// Password Area

    if (password_verify($old_password, $row['user_password'])) {
        if (empty($password) and empty($comfirm_password)) {
            $pass = $row['user_password'];
        } else if ($password !== $comfirm_password) {
            $errorMsg = "Password mismatch enter password again";
        } else if (strlen($password)  < 8) {
            $errorMsg = "Password too weak!!! MUST be more than 8 characters";
        } else {
            $options = [
                'cost' => 12,
            ];
            $pass = password_hash($password, PASSWORD_BCRYPT, $options);
        }
    } else $errorMsg = "Your old Password is wrong";

    if (!isset($errorMsg)) {
        try {
            $username = ucfirst($username);
            $update_user = $db->prepare("UPDATE user SET username=:uusername, user_password=:upassword, user_firstname=:ufirstname, user_lastname=:ulastname, user_email=:uemail, user_image=:uimage WHERE user_id=:userid");
            $update_user->bindParam(":uusername", $username);
            $update_user->bindParam(":upassword", $pass);
            $update_user->bindParam(":ufirstname", $fristname);
            $update_user->bindParam(":ulastname", $lastname);
            $update_user->bindParam(":uemail", $email);
            $update_user->bindParam(":uimage", $image_file);
            $update_user->bindParam(":userid", $userId);
            $results = $update_user->execute();
            if ($results) {
                $updateMsg = "Inserted successfully....";
            }
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

    <!-- firstname -->
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" id="exampleInput" value="<?php echo $user_firstname ?>" name="txt_firstname" required>
    </div>

    <!-- lastname -->
    <div class="form-group">
        <label for="author">Lastname</label>
        <input type="text" class="form-control" id="exampleInput" value="<?php echo $user_lastname ?>" name="txt_lastname" required>
    </div>
    <!-- username -->
    <div class="form-group">
        <label for="status">Username</label>
        <input type="text" class="form-control" id="exampleInput" value="<?php echo $username ?>" name="txt_username" required>
    </div>

    <!-- Post image -->
    <div class="row">
        <div class="form-group col-md-6">
            <label for="title">Post Image</label>
            <input type="file" class="form-control" value="<?php echo $user_image ?>" id="exampleInput" name="txt_file">
            <span style="color: red">image must be less than 1 mp</span>
        </div>
        <div class="form-group col-md-6">
            <label for="pic">Present Pic</label>
            <img src="../images/userImage/<?php echo $user_image ?>" width="100" alt="image">
        </div>
    </div>
    <!-- Old password -->
    <div class="form-group">
        <label for="tag">Old Password</label>
        <input type="password" class="form-control" id="exampleInput" placeholder="Enter Your old Password" name="txt_old_password" required>
    </div>
    <!-- password -->
    <div class="form-group">
        <label for="tag">New Password</label>
        <input type="password" class="form-control" id="exampleInput" placeholder="Enter Your New Password" name="txt_password">
    </div>
    <!-- comfirm password -->
    <div class="form-group">
        <label for="tag">New Comfirm Password</label>
        <input type="password" class="form-control" id="exampleInput" placeholder="Comfirm Your New Password" name="txt_comfirm_password">
    </div>
    <!-- Post Content -->
    <div class="form-group">
        <label for="content">Email</label>
        <input type="email" class="form-control" id="exampleInput" value="<?php echo $user_email ?>" name="txt_email" required>
    </div>
    <!-- submit -->
    <div class="text-center form-group">
        <button type="submit" class="btn btn-primary" name="edit_user">Edit User</button>
    </div>
</form>