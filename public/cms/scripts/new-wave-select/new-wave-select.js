class NewWaveSelect {
    constructor(selector) {
        const WRAPPER_CLASS = 'select';
        const WRAPPER_ACTIVE_CLASS = 'active';
        const WRAPPER_DATA_SET = 'data-select';
        const SELECTED_TEXT_CLASS = 'select__chosen input';
        const LIST_CLASS = 'select__list';
        const OPTION_CLASS = 'select__option';
        const OPTION_ACTIVE_CLASS = 'active';

        let customSelects = document.querySelectorAll(selector);
        customSelects.forEach((customSelect) => {

            // create wrapper
            let wrapper = document.createElement('div');
            wrapper.className = WRAPPER_CLASS;

            customSelect.replaceWith(wrapper);
            wrapper.setAttribute(WRAPPER_DATA_SET, '');
            wrapper.appendChild(customSelect);

            // create text
            let selectedText = document.createElement('p');
            selectedText.className = SELECTED_TEXT_CLASS;
            selectedText.textContent = customSelect.options[customSelect.selectedIndex].text;
            wrapper.appendChild(selectedText);

            // create options list
            let dropdownList = document.createElement('ul');
            dropdownList.className = LIST_CLASS;
            wrapper.appendChild(dropdownList);

            // create options items
            let opts = customSelect.querySelectorAll('option');
            opts.forEach((opt) => {
                let optionsItem = document.createElement('li');
                optionsItem.className = OPTION_CLASS;
                optionsItem.setAttribute('data-value', opt.value);
                optionsItem.textContent = opt.textContent;
                dropdownList.appendChild(optionsItem);
            });

            // set events
            dropdownList.addEventListener('click', e => {
                const optionValue = e.target.closest('li');
                selectedText.textContent = optionValue.textContent;
                customSelect.value = optionValue.dataset.value;
                wrapper.classList.remove(WRAPPER_ACTIVE_CLASS);
            });

            selectedText.addEventListener('click', () => {
                if (wrapper.classList.contains(WRAPPER_ACTIVE_CLASS)) {
                    wrapper.classList.remove(WRAPPER_ACTIVE_CLASS);
                } else {
                    let activeDropdown = document.querySelectorAll('[' + WRAPPER_DATA_SET + '].' + WRAPPER_ACTIVE_CLASS);
                    activeDropdown.forEach(item => item.classList.remove(OPTION_ACTIVE_CLASS));
                    wrapper.classList.add(WRAPPER_ACTIVE_CLASS);
                }
            });

            document.addEventListener('click', e => {
                let activeDropdown = document.querySelectorAll('[' + WRAPPER_DATA_SET + '].' + WRAPPER_ACTIVE_CLASS);
            
                if (!e.target.closest('[' + WRAPPER_DATA_SET + ']') && activeDropdown) {
                    activeDropdown.forEach(item => item.classList.remove(OPTION_ACTIVE_CLASS));
                }
            });

        });

    }



};