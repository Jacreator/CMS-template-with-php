<?php include "../codes/connection.php"; 
ob_start();
session_start();
?>
<?php
if (isset($_POST['submit_login'])) {
    $username = $_POST['txt_username'];
    $password = $_POST['txt_password'];
    try {
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $username = ucfirst($username);
        $selectUser = $db->prepare("SELECT * FROM user WHERE username=:uuser");
        $selectUser->bindParam(":uuser", $username);
        if ($selectUser->execute()) {
            $row = $selectUser->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['user_password'])) {
                    $_SESSION['firstname'] = $row['user_firstname'];
                    $_SESSION['lastname'] = $row['user_lastname'];
                    $_SESSION['role'] = $row['user_role'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['u_id'] = $row['user_id'];
                    header("Location: ../admin/admin_index.php");
            } else {
                $errorMsg = "Password mismatch";
                header("Location../index.php");
            }
        } else {
            $errorMsg = "Unknown Username";
            header("Location../index.php");
        }
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
}
?>
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