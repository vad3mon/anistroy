document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('.draggable-table')) {
        new PositionedTables('.draggable-table');
    }
    
    // delete buttons
    document.querySelectorAll('[data-list-table] a[data-delete]').forEach((button) => {
        button.addEventListener('click', (event) => {
            if(confirm(button.getAttribute('data-confirm'))) {

                fetch(button.getAttribute('data-route'), {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    method: 'DELETE',
                })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    if(data.result == 'ok') {
                        document.querySelector('.model-table tr[data-id="' + data.id + '"]').remove();
                    }
                });
            }
        });
    });

});
