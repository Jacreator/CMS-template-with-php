<?php
if (isset($_POST['create_user'])) {
         
    $select_stmt = $db->prepare('SELECT * FROM user'); //sql select query
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $fristname = $_POST['txt_firstname']; // textbox name "txt_firstname"
    $lastname = $_POST['txt_lastname']; //textbox name "txt_lastname"
    $username = $_POST['txt_username']; // textbox name "txt_username"
    $role = $_POST['txt_role']; // textbox name "txt_role"
    $email = $_POST['txt_email']; // textbox name "txt_email"
    $password = $_POST['txt_password']; // textbox name "txt_password"
    $comfirm_password = $_POST['txt_comfirm_password']; // textbox name "txt_comfirm_password"

    $image_file = $_FILES['txt_file']['name']; // get the name of a file and textbox name "text_file"
    $image_temp_location = $_FILES["txt_file"]["tmp_name"]; // temporay location for file
    $size = $_FILES['txt_file']['size'];
    if (empty($image_file) and ($size > 1000000)) {
        $errorMsg = "Pleas choose an Image";
        $errorMsg .= "Your File To large Please Upload 1MB Size"; //error message file size not large than 5MB
    }
    if($username == $row['username']){
        $errorMsg = "Username already taken";
    }
    if ($password == $comfirm_password) {
        $options = [
            'cost' => 12,
        ];
        $pass = password_hash($password, PASSWORD_BCRYPT, $options);
    } else $errorMsg = "Password mismatch try again";
    if (!isset($errorMsg)) {
        try {
            $username = ucfirst($username);
            $insert_user = $db->prepare("INSERT INTO user(username, user_password, user_firstname, user_lastname,  user_email, user_image, user_role) VALUES(:uusername, :upassword, :ufirstname, :ulastname, :uemail, :uimage,  :urole)");
            $insert_user->bindParam(":uusername", $username);
            $insert_user->bindParam(":upassword", $pass);
            $insert_user->bindParam(":ufirstname", $fristname);
            $insert_user->bindParam(":ulastname", $lastname);
            $insert_user->bindParam(":uemail", $email);
            $insert_user->bindParam(":uimage", $image_file);
            $insert_user->bindParam(":urole", $role);
            
            if ($insert_user->execute()) {
                $updateMsg = "Inserted successfully....";
                move_uploaded_file($image_temp_location, "../images/userImage/" . $image_file);    //move upload file temperory directory to your upload folder	
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
}

?>
    <!-- firstname -->
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" id="exampleInput" placeholder="Enter firstname" name="txt_firstname"
            required>
    </div>

    <!-- lastname -->
    <div class="form-group">
        <label for="author">Lastname</label>
        <input type="text" class="form-control" id="exampleInput" placeholder="Enter lastname" name="txt_lastname"
            required>
    </div>
    <!-- username -->
    <div class="form-group">
        <label for="status">Username</label>
        <input type="text" class="form-control" id="exampleInput" placeholder="Enter username" name="txt_username"
            required>
    </div>
    <!-- role -->
    <div class="form-group">
        <label for="role">Role</label>
        <select name="txt_role" id="" class="form-control" required>
            <option>Select one</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>

    <!-- Post image -->
    <div class="form-group">
        <label for="title">Post Image</label>
        <input type="file" class="form-control" id="exampleInput" name="txt_file" required>
        <span style="color: red">image must be less than 1 mp</span>
    </div>
    <!-- password -->
    <div class="form-group">
        <label for="tag">Password</label>
        <input type="password" class="form-control" id="exampleInput" placeholder="Enter password" name="txt_password"
            required>
    </div>
    <!-- comfirm password -->
    <div class="form-group">
        <label for="tag">Comfirm Password</label>
        <input type="password" class="form-control" id="exampleInput" placeholder="Enter password again"
            name="txt_comfirm_password" required>
    </div>
    <!-- Post Content -->
    <div class="form-group">
        <label for="content">Email</label>
        <input type="email" class="form-control" id="exampleInput" placeholder="Enter email" name="txt_email" required>
    </div>
    <!-- submit -->
    <div class="text-center form-group">
        <button type="submit" class="btn btn-primary" name="create_user">Add User</button>
    </div>
</form>