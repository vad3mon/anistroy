const jsonSetRemoveButtons = () => {
    let jsonRemoveBtns = document.querySelectorAll('.json_remove');
    jsonRemoveBtns.forEach((btnRemove) => {
        btnRemove.onclick = (event) => {
            event.preventDefault();

            if(confirm(btnRemove.getAttribute('data-confirm'))) {
                btnRemove.parentElement.remove();
            }
        };
    });
}


document.addEventListener('DOMContentLoaded', () => {
    let jsonAddBtns = document.querySelectorAll('.json_add');
    jsonAddBtns.forEach((btnAdd) => {
        btnAdd.addEventListener('click', (event) => {
            event.preventDefault();

            let fieldName = btnAdd.dataset.field;
            let jsonTemplate = document.getElementById('json_template_' + fieldName);
            let jsonFields = document.getElementById('json_fields_' + fieldName);

            jsonFields.appendChild(jsonTemplate.firstElementChild.cloneNode(true));

            jsonSetRemoveButtons();
        });
    });

    jsonSetRemoveButtons();

    let jsonLists = document.querySelectorAll('.json_sortable');
    jsonLists.forEach((jsonList) => {
        let sortable = new Sortable(jsonList, {});
    });



    cmsForm = document.getElementById('cms_data_form');

    cmsForm.addEventListener('submit', event => {

        jsonFieldTemplates = document.querySelectorAll('.json_field_template');
        
        jsonFieldTemplates.forEach(jsonFieldTemplate => {
            jsonFieldTemplate.remove();
        });
    });


});



