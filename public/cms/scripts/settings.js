document.addEventListener('DOMContentLoaded', event => {
    let blockButtons = document.querySelectorAll('.content__tabs.tabs button');
    let blocks = document.querySelectorAll('.settings_block');

    blockButtons.forEach((btn) => {
        btn.addEventListener('click', (event) => {
            event.preventDefault();

            blocks.forEach((block) => {
                block.classList.remove('active');
            });

            blockButtons.forEach((btn) => {
                btn.classList.remove('active');
            });

            let blockId = btn.dataset.block;
            btn.classList.add('active');

            let selectedBlock = document.getElementById('settings_block_' + blockId);
            selectedBlock.classList.add('active');

        });
    });
});