tinymce.init({ selector: 'textarea' });

$(document).ready(function () {
    alert('working');
    $('#selectAllCheckBoxes').click(function () {
        if (this.checked) {
            $('.checkboxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkboxes').each(function () {
                this.checked = false;
            });
        }
    });
});