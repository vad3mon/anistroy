
    class SelectWithPosition {
        constructor(selector) {
            let selWithPosEls = document.querySelectorAll(selector);
            selWithPosEls.forEach(el => {
                new _SelectWithPosition(el);
            });
        }
    }


    class _SelectWithPosition {

        constructor(selectElement) {
            this.selectElement = selectElement;

            // create the overall container
            this.overallContainer = document.createElement('div');
            this.overallContainer.className = 'sel_pos_container';
            this.selectElement.after(this.overallContainer);

            // create the list container
            let listContainer = document.createElement('div');
            listContainer.className = 'sel_pos_list';
            this.overallContainer.appendChild(listContainer);


            // create list of elements
            this.selectedElementsList = document.createElement('ul');
            listContainer.appendChild(this.selectedElementsList);

            // add elements to the list
            for(let selectedOption of this.selectElement.selectedOptions) {
                let element = document.createElement('li');
                element.setAttribute('data-value', selectedOption.value);
                element.textContent = selectedOption.textContent;
                this.selectedElementsList.appendChild(element);

                let removeBtn = document.createElement('button');
                removeBtn.addEventListener('click', this.removeElement.bind(this));
                element.appendChild(removeBtn);
            }

            // make thee list sortable
            var sortable = new Sortable(this.selectedElementsList, {
                callback: this.doResort.bind(this)
                });

            // create the ADD button
            let addBtn = document.createElement('button');
            addBtn.className = 'sel_pos_add';
            addBtn.textConntent = '+';
            addBtn.addEventListener('click', this.showPopup.bind(this));
            listContainer.appendChild(addBtn);

            // create popup
            let popupToAdd = document.createElement('div');
            popupToAdd.className = 'sel_pos_popup';
            this.overallContainer.appendChild(popupToAdd);

            // copy the select (for popup)
            let popupSel = this.selectElement.cloneNode(true);

            for(let i = popupSel.options.length - 1; i >= 0; i--) {
                if(popupSel.options[i].selected) {
                    popupSel.options[i].remove();
                }
            }

            popupSel.removeAttribute('multiple');
            popupSel.removeAttribute('id');
            popupSel.removeAttribute('name');
            popupSel.setAttribute('size', '5');
            popupSel.addEventListener('dblclick', this.addElement.bind(this));
            popupToAdd.appendChild(popupSel);

            this.selectElement.setAttribute('multiple', 'multiple');



            this.selectElement.style.display = 'none';


            // remove not selected items
            for(let i = 0; i < this.selectElement.options.length; i++) {
                if(!this.selectElement.options[i].selected) {
                    this.selectElement.options[i].remove();
                }
            }


        }


        showPopup(event) {
            event.preventDefault();
            if(this.overallContainer.classList.contains('action_show_popup')) {
                this.overallContainer.classList.remove('action_show_popup');
            }
            else {
                this.overallContainer.classList.add('action_show_popup');
            }
        }

        closePopup() {
            this.overallContainer.classList.remove('action_show_popup');
        }

        addElement(event) {
            event.preventDefault();

            let selectedOption = event.target;

            // check if the option is already added
            let optionExists = false;
            for(let i = 0; i < this.selectElement.options.length; i++) {
                if(this.selectElement.options[i].value == selectedOption.value) {
                    optionExists = true;
                }
            }

            if(!optionExists) {
                let element = document.createElement('li');
                element.setAttribute('data-value', selectedOption.value);
                element.textContent = selectedOption.textContent;
                this.selectedElementsList.appendChild(element);

                let removeBtn = document.createElement('button');
                removeBtn.addEventListener('click', this.removeElement.bind(this));
                element.appendChild(removeBtn);

                let opt = document.createElement('option');
                opt.textContent = selectedOption.textContent;
                opt.value = selectedOption.value;
                opt.setAttribute('selected', 'selected');
                this.selectElement.appendChild(opt);

            }
            this.closePopup();

        }

        doResort(data) {
            while(this.selectElement.firstChild) {
              this.selectElement.removeChild(this.selectElement.lastChild);
            }

            data.forEach(value => {
                let opt = document.createElement('option');
                opt.value = value;
                opt.setAttribute('selected', 'selected');
                this.selectElement.appendChild(opt);
            });
        }


        removeElement(event) {
            event.preventDefault();

            let value = event.target.parentNode.getAttribute('data-value');

            for(let i = 0; i < this.selectElement.options.length; i++) {
                if(this.selectElement.options[i].value == value) {
                    this.selectElement.options[i].remove();
                }
            }

            event.target.parentNode.remove();
        }


    }




