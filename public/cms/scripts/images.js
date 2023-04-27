document.querySelectorAll('.image_remove').forEach((imageRemoveBtn) => {
    imageRemoveBtn.addEventListener('click', (event) => {
        event.preventDefault();
        if(confirm(event.target.dataset.confirm)) {
            image = document.querySelector('.image_' + imageRemoveBtn.dataset.image);
            if(image) {
                image.remove();
                imageDelete = document.querySelector('.image_' + imageRemoveBtn.dataset.image + '_delete').value = '1';    
            }
        }
    });
});
