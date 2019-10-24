/**
 * Adnan Bashir
 * Email:  developer.adnan@gmail.com
 */

tinyMCE.init({
    mode: "textareas",
    editor_selector: "editor",

    relative_urls: true,
    remove_script_host: false,
    forced_root_block: '',
    verify_html: false,

    theme: "advanced",
    //script_url : "tiny_mce.js",
    /*skin: "bootstrap",*/
    /*skin_variant: "silver",*/

    //filemanager,imagemanager,
    plugins: "filemanager,imagemanager,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

    // Theme options
    theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,|,insertimage,insertfile,|,shortcodes",//widgets,
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,

    // Example content CSS (should be your site CSS)
    content_css: media_url + "/css/editor.css",

    /*relative_url: false,
    relative_urls: true,
    document_base_url: base_url,*/

    language: "en",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url: asset_url + "tiny_mce/lists/templates_list.php",
    external_link_list_url: "lists/link_list.js",



    // Replace values for the template plugin
    template_replace_values: {
        username: "Some User",
        staffid: "991234"
    },
    setup : function(ed) {
        ed.addButton('shortcodes', {
            title : 'Short Codes',
            image : asset_url + 'admin/tiny_mce/themes/code.png',
            onclick : function() {

                var dialog = bootbox.dialog({
                    title: 'Shortcode',
                    message: '<div class="row">\
                            <div class="col-sm-6 alert alert-dark"><a href="#" class="ed-put-html">[omd_material type="Annual Report"]</a></div>\
                            <div class="col-sm-6 alert alert-dark"><a href="#" class="ed-put-html">[cms_block identifier="about-us"]</a></div>\
                            <div class="col-sm-6 alert alert-dark"><a href="#" class="ed-put-html">[include file="example.php"]</a></div>\
                            <div class="col-sm-6 alert alert-dark"><a href="#" class="ed-put-html">[option name="site_title"]</a></div>\
                            <div class="col-sm-6 alert alert-dark"><a href="#" class="ed-put-html">[stars rows="3"]</a></div>\
                            <div class="col-sm-6 alert alert-dark"><a href="#" class="ed-put-html">[events rows="5"]</a></div>\
                            </div>'});
                //$('.bootbox  > .modal-body').css('padding', '0');
                $('.ed-put-html').on('click', function (e) {
                    e.preventDefault();
                    var shortCode = $(this).html();
                    ed.execCommand('mceInsertContent', false, shortCode);
                    dialog.modal('hide');
                });
            }
        });
    }
});


/*-------------------------------------------------------------------------*/

tinyMCE.init({
    mode: "textareas",
    editor_selector: "small_editor",
    theme: "advanced",
    skin: "o2k7",
    skin_variant: "silver",
    forced_root_block: '',
    verify_html: false,
    //plugins: "imagemanager",

    /*relative_urls: false,
        remove_script_host: false,*/

    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,
    file_browser_callback: "imagemanager",
    theme_advanced_resize_horizontal: true,
    theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

    // Example content CSS (should be your site CSS)
    content_css: media_url + "/css/editor.css"
});

tinyMCE.init({
    mode: "textareas",
    editor_selector: "simple_editor",
    theme: "simple",
    forced_root_block: '',
    verify_html: false,
});