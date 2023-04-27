document.addEventListener('DOMContentLoaded', () => {
    password = document.getElementById('password');
    passwordConfirm = document.getElementById('password_confirm');
    passwordValidationErr = document.getElementById('password_validation_err');

    cmsForm = document.getElementById('cms_data_form');

    cmsForm.addEventListener('submit', event => {
        if((password.value || passwordConfirm.value) && (password.value != passwordConfirm.value)) {
            passwordValidationErr.style.display = 'block';
            password.scrollIntoView();
            event.preventDefault();
        }
        
    });

    
    document.querySelectorAll('#cms_data_form input, #cms_data_form textarea, #cms_data_form select').forEach((changable) => {
        changable.addEventListener('change', () => {
            window.onbeforeunload = () => {
                return true;
            };
        });
    });

    document.getElementById('cms_data_form').addEventListener('submit', (event) => {
        window.onbeforeunload = null;
    });


});



