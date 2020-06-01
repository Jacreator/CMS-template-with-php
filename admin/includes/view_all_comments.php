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
?><table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Email</th>
            <th>Content</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Apporved</th>
            <th>Unapproved</th>
            <th>Opreation</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            commentSelect(); 
            deleteComment();
            approveComment();
            unApproveComment();
        ?>
    </tbody>
</table>