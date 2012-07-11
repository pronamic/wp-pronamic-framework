(function( $ ){

  $.fn.pronamicWordPressFileSelect = function( options ) {  

    return this.each(function() {        

    	var $this = $(this), data = $this.data("pronamic-wp-file-select");

    	if ( ! data ) {
           
    		$this.data("pronamic-wp-file-select", {
                target : $this
            });

            var id = $this.attr("id");

            var selectButton = $('<input type="button" />')
    			.val(pronamicFileSelect.selectFileText)
    			.addClass("button-secondary")
    			.click(function() {
    				window.pronamicSelectField = $this;

    				tb_show( 
    					pronamicFileSelect.selectFileText , 
    					"media-upload.php" + "?" + $.param({
    						post_id: "" , 
    						pronamic_file_select_field: id ,  
    						tab: "library" , 
    						send: "false" , 
    						type: "file" , 
    						TB_iframe: "true" 
    					})
    				);

    				return false;
    			});

            $this.after(selectButton);

            var check = $('<input type="checkbox" />');

            $this.after(check);
    	}

    });

  };
})( jQuery );

jQuery( document ).ready( function( $ ) {
	$(".pronamic-file-select").pronamicWordPressFileSelect();
});

jQuery( document ).ready( function( $ ) {
	if( parent.pronamicSelectField ) {
		$("body").addClass("pronamic-select-file");

		$(".media-upload-form").bind("click.uploader", function(e) {
			var target = $(e.target), tr, c;

			if ( target.is(".pronamic-select-file-button") ) {
				var post_id = target.data("post_id");

				parent.pronamicSelectFile( post_id );

				return false;
			}
		});

		$("ul#sidemenu li#tab-type_url").remove();
	}
});

function pronamicSelectFile( post_id ) {
	var field = window.pronamicSelectField;

	var preview = jQuery( '#' + field.attr("id") + '_preview' );

	// Load preview image
	preview.empty().load(ajaxurl, {
		id: post_id , 
		action:	"pronamic_file_select_preview"
	});

	// Pass ID to form field
	field.val( post_id );

	// Close interface down
	tb_remove();

	delete window.pronamicSelectField;
}
