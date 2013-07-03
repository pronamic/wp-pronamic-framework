<?php

class Pronamic_Comment_Form {
		
	public function __construct() {
		add_action( 'comment_form_before', array( $this, 'show_comment_form_before_text' ) );
	}
	
	public function show_comment_form_before_text() {
		echo get_option( 'pronamic_framework_comment_form_before_text', '' );
	}
	
}

new Pronamic_Comment_Form();