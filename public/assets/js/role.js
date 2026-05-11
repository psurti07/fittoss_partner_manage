document.getElementById('contact-top-tab').addEventListener('click', function (event) {
    event.preventDefault();

    const checkboxes = document.querySelectorAll('.ath_container input[type="checkbox"]');

    const allChecked = Array.from(checkboxes).every(function (checkbox) {
        return checkbox.checked;
    });

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = !allChecked;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.check_row').forEach(function (masterCheckbox) {
        masterCheckbox.addEventListener('change', function () {
            const group = this.getAttribute('data-group');
            const checkboxes = document.querySelectorAll(`.${group}`);
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = masterCheckbox.checked;
            });
        });
    });

    document.querySelectorAll('input[type="checkbox"][name="permissions[]"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const group = this.closest('tr').querySelector('.check_row').getAttribute('data-group');
            const masterCheckbox = document.querySelector(`.check_row[data-group="${group}"]`);
            const checkboxes = document.querySelectorAll(`.${group}`);

            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

            masterCheckbox.checked = allChecked;
            masterCheckbox.indeterminate = !allChecked && anyChecked;
        });
    });
});


$(document).ready(function () {
    $('form').on('submit', function (event) {
        event.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.href = url;
            },
            error: function (xhr) {
                $('input').removeClass('is-invalid');
                $('.error-message').remove();
                let response = xhr.responseJSON || {};
                let errors = response.errors || {};
                let errorMessage = response.error || 'An unexpected error occurred.';

                if (errors) {
                    $.each(errors, function (field, messages) {
                        if (field === 'permissions') {
                            let errorElement = $('<div class="error-message" style="color: red;"></div>').text(messages.join(' '));

                            $('input[name="permissions[]"]').each(function() {
                                if ($(this).closest('td').find('.error-message').length === 0) {
                                    $(this).after(errorElement.clone()); // Add the same error message to each relevant checkbox
                                }
                            });
                        } else {
                            let inputField = $(`[name="${field}"]`);
                            inputField.addClass('is-invalid');
                            let errorElement = $('<div class="error-message" style="color: red;"></div>').text(messages.join(' '));
                            inputField.after(errorElement);
                        }
                    });
                } else {
                    alert(errorMessage);
                }
            }
        });
    });
});



