jQuery(document).ready(function($) {
    //create TinyMCE plugin
    tinymce.create('tinymce.plugins.sh_custom_plugin', {
        init : function(ed, url) {
            // Setup the command when the button is pressed
            ed.addCommand('sh_custom_insert_shortcode', function() {
                //get the selected content
                selected = tinyMCE.activeEditor.selection.getContent();
                //check if content selected or not
                if( selected ){
                    //If the text is selected when the button is pressed, wrap the shortcut around it.
                    content =  '[logged_users]'+selected+'[/logged_users]';
                }else{
                    //If the text is not selected when the button is pressed, display default short code.
                    content =  '[logged_users] Add your private content here. [/logged_users]';
                }
                //
                tinymce.execCommand('mceInsertContent', false, content);
            });
            //Add Button to Visual Editor Toolbar and launch the above command when it is clicked.
            // image: url + '/user.png' - here you can add your image path.
            ed.addButton('sh_custom_button', {
                title : 'Insert shortcode',
                cmd : 'sh_custom_insert_shortcode',
                image: url + '/user.png'
            });
        },
    });
    //Setup the TinyMCE plugin. The first parameter is the button ID and the second parameter must match the first parameter of the above "tinymce.create ()" function.
    tinymce.PluginManager.add('sh_custom_button', tinymce.plugins.sh_custom_plugin);
});