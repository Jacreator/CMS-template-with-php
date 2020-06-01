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
<table class="table table-hover table-bored">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Fristname</th>
            <th>Lastname</th>
            <th>Image</th>
            <th>Role</th>
            <th>email</th>
            <th colspan="2" class="text-center">Opreation</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            userSelect(); 
            deleteUser();
            changeToAdmin();
            changeToSubscriber();
        ?>
    </tbody>
</table>