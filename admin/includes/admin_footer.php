</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- custom JavaScript -->
<script src="<?php echo 'js/scripts.js' ?>"></script>

<script>
    $(document).ready(function() {
        $('#selectAllCheckBoxes').click(function() {
            if (this.checked) {
                $('.checkboxes').each(function() {
                    this.checked = true;
                });
            } else {
                $('.checkboxes').each(function() {
                    this.checked = false;
                });
            }
        });
    });
</script>

</body>

</html>