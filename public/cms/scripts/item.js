document.addEventListener('DOMContentLoaded', event => {

    new SelectWithPosition('.set_ordered');
    applyWysiwyg();

    document.querySelectorAll('.dropdown_multy').forEach(selectr => {
        new Selectr(selectr);
    });

    document.querySelectorAll('.dropdown_one').forEach(selectr => {
        new Selectr(selectr);
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


