(function( $ ){

  $.fn.pronamicWordPressMediaSelect = function( options ) {  

    return this.each(function() {        

    	var $this = $(this), data = $this.data("pronamic-wp-media-select");

    	if ( ! data ) {

    		var $preview = jQuery( '#' + $this.attr("id") + '_preview' );

    		$this.data("pronamic-wp-media-select", {
                target : $this , 
                preview : $preview
            });

            var $selectButton = $('<input type="button" />')
    			.val(pronamicMediaSelectL10n.selectMediaText)
    			.addClass("button-secondary")
    			.click(function() {
    				window.pronamicSelectField = $this;

    				tb_show( 
    					pronamicMediaSelectL10n.selectMediaText , 
    					"media-upload.php" + "?" + $.param({
    						post_id: "" , 
    						// tab: "library" , 
    						// type: "file" , 
    						TB_iframe: "true" 
    					})
    				);

    				return false;
    			});

            var $deleteButton = $('<input type="button" />')
    			.val(pronamicMediaSelectL10n.deleteText)
    			.addClass("button-secondary")
    			.click(function() {
    				$this.val("");
    				$preview.empty();

    				return false;
    			});

    		var $div = $("<div />");

            $div.append($selectButton);
            $div.append(" ");
            $div.append($deleteButton);

    		$this.after($div).hide();
    	}
    });

  };
})( jQuery );

//http://digitalize.ca/2010/09/wordpress-tip-hooking-into-widget-save-callback/
//http://www.johngadbois.com/adding-your-own-callbacks-to-wordpress-ajax-requests/
//http://api.jquery.com/category/ajax/global-ajax-event-handlers/
jQuery(document).ajaxSuccess(function(e, xhr, settings) {
    if ( typeof( settings.data ) !== 'undefined' && settings.data.search( 'action=save-widget' ) != -1 ) {
		$("input.pronamic-file-select").pronamicWordPressFileSelect();
	}
});

jQuery( document ).ready( function( $ ) {
	$("input.pronamic-media-select").pronamicWordPressMediaSelect();

	// Media select popup
	if( parent.pronamicSelectField ) {
		$("body").addClass("pronamic-media-select");

		$(".media-upload-form").bind("click.uploader", function(e) {
			var target = $(e.target), tr, c;

			if ( target.is(".pronamic-media-select-button") ) {
				var win = window.dialogArguments || opener || parent || top;

				var post_id = target.data("post_id");

				win.pronamicSelectFile( post_id );

				return false;
			}
		});

		$("ul#sidemenu li#tab-type_url").remove();
	}
});

function pronamicSelectFile( post_id ) {
	var field = window.pronamicSelectField;

	if( field ) {
		var data = field.data("pronamic-wp-media-select");

		// Load preview image
		if(data.preview) {
			data.preview
				.text(pronamicMediaSelectL10n.loadingPreviewText)
				.load(ajaxurl, {
					id: post_id , 
					action:	"pronamic_media_select_preview"
				});
		}

		// Pass ID to form field
		field.val( post_id );
	}

	// Close interface down
	tb_remove();

	delete window.pronamicSelectField;
}
