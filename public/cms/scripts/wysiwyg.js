function applyWysiwyg() {
	tinymce.init({

		language: 'ru',
		mode: 'textareas',
		selector: '.wysiwyg',
		branding: false,
		height: 400,
		document_base_url: '/',
		allow_unsafe_link_target: true,
		plugins: 'paste',
		paste_block_drop: true,

        content_css: "/cms/styles/tinymce.css",


		init_instance_callback: function (editor) {
			editor.on('change', function (event) {
                window.onbeforeunload = () => {
                    return true;
                };
			});
		},

		invalid_elements : 'span,div',
 		formats: {
			removeformat: [
			  { selector: 'p,br', remove: 'none' },
		  	]
		},

		plugins : 'advlist table autolink link lists charmap fullscreen code paste searchreplace media anchor image',


		menu: {
		//    file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
		    edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
		    view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
		    insert: { title: 'Insert', items: 'link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
		    format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats blockformats align | removeformat' },
		    tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
		    table: { title: 'Table', items: 'inserttable tableprops deletetable row column cell' },
		    help: { title: 'Help', items: 'help' },
			},

		toolbar: "br | editor_note | removeformat | undo redo | bold italic blockquote | formatselect | alignleft alignright aligncenter alignjustify | numlist bullist | code fullscreen",

		menubar: 'edit insert view format table tools custom',


		style_formats: [],


		setup: function (editor) {
			var toggleState = false;

            editor.ui.registry.addButton('br', {
                text: '&crarr;',
                onAction: function() {
                    editor.execCommand('InsertLineBreak');   
                }
            });

            editor.ui.registry.addButton('editor_note', {
                text: 'Примечание редактора',
                onAction: function() {
                    let selectedNode = editor.selection.getNode();
                    let editorNoteText = '';

                    if(selectedNode.nodeName == 'EM' && selectedNode.classList.contains('editor_note')) {
                        editorNoteText = selectedNode.getAttribute('data-title');
                    }

                    editor.windowManager.open({
                        title: 'Примечание редактора',
                        body: {
                            type: 'panel',
                            items: [{
                                type: 'textarea',
                                name: 'editor_note',
                                label: 'Текст примечания',
                                flex: true
                            }]
                        },
                        initialData: {
                            editor_note: editorNoteText
                        },
                        onSubmit: function (api) {
                            let selectedNode = editor.selection.getNode();
                            let editorNote = api.getData().editor_note;

                            if(selectedNode.nodeName == 'EM' && selectedNode.classList.contains('editor_note')) {
                                if(editorNote) {
                                    selectedNode.setAttribute('data-title', editorNote);
                                }
                                else {
                                    let justText = document.createTextNode(selectedNode.innerText);
                                    selectedNode.replaceWith(justText);
                                }
                            }
                            else {
                                editor.selection.setContent('<em class="editor_note" data-title="' + editorNote + '">' + editor.selection.getContent({format: 'text'}) + '</em>');
                            }
                            api.close();
                        },
                        buttons: [
                            {
                                text: 'Закрыть',
                                type: 'cancel',
                                onclick: 'close'
                            },
                            {
                                text: 'Вставить',
                                type: 'submit',
                                primary: true,
                                enabled: false
                            }
                        ]
                    });
                }
            });

			}
		});



	}



/*
var wysiwygEditors = [];


wysiwyg = document.querySelectorAll('.wysiwyg');
i = 0;
wysiwyg.forEach((wysiwygNode) => {
    wysiwygNode.setAttribute('data-wysiwyg-editor', i);
    i++;
    const wysiwygEditor = SUNEDITOR.create(wysiwygNode, {
        buttonList: [
            ['undo', 'redo'],
            ['font', 'fontSize', 'formatBlock'],
            ['paragraphStyle', 'blockquote'],
            ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
            ['fontColor', 'hiliteColor', 'textStyle'],
            ['removeFormat'],
            '/', // Line break
            ['outdent', 'indent'],
            ['align', 'horizontalRule', 'list', 'lineHeight'],
            ['table', 'link', 'image', 'video', 'audio'], // You must add the 'katex' library at options to use the 'math' plugin.
            ['fullScreen', 'showBlocks', 'codeView'],
            ['preview', 'print'],
            ['save', 'template'],
        ]
    });
    wysiwygEditors.push(wysiwygEditor);
});

document.getElementById('cms_data_form').addEventListener('submit', (event) => {
    // обновление данных WYSIWYG-редакторов перед сохранением
    for(let i = 0; i < wysiwygEditors.length; i++) {
        let wysiwyg = document.querySelector('textarea[data-wysiwyg-editor="' + i + '"]');
        wysiwyg.value = wysiwygEditors[i].getContents();
    }
});
*/
