<?php
/**
* Change layout of the comment form
*
* http://wordpress.org/support/topic/change-comment-form-labels-twenty-eleven
* http://wordpress.stackexchange.com/questions/50593/how-to-rearrange-fields-in-comment-form
* http://www.1stwebdesigner.com/wordpress/comment-form-customization/
*
* (c) Twin Dots Limited 
* Distributed via ThemeForest under GPLv2 (or later)
*
*/

if(!function_exists('lbmn_custom_comment_form_fields')) {
	function lbmn_custom_comment_form_fields($fields) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$comment_textarea['custom_comment_area'] =
		'<div class="customized-comment-form comment-form row">' .
			'<div class="comment-area large-12 columns">' .
				'<div class="comment-form-comment">' .
					/*'<label for="comment">' . _x( 'Comment', 'noun', 'lbmn' ) . '</label>' .*/
					'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
				'</div>' .
			'</div>';

		array_unshift($fields, $comment_textarea['custom_comment_area']);
		$fields['author'] =
			'<div class="comment-author-info large-12 columns">' .
			'<div class="row">' .
				'<div class="comment-form-author large-4 columns">' .
					'<label for="author">' .
						__( 'Name', 'lbmn' ) . ( $req ? ' <span class="required">*</span>' : '' ) .
					'</label> ' .
		 			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
		 		'</div>';

		 		$fields['email'] =
		 		'<div class="comment-form-email large-4 columns">' .
		 			'<label for="email">' .
		 				__( 'Email', 'lbmn' ) . ( $req ? ' <span class="required">*</span>' : '' ) .
		 			'</label> ' .
		 			'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
		 		'</div>';


				$fields['url'] =
				'<div class="comment-form-url large-4 columns">' .
					'<label for="url">' .
						__( 'Website', 'lbmn' ) .
					'</label>' .
					'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />' .
				'</div>' .
			'</div>'. //row
			'</div>'. //comment-author-info
		'</div>'; //customized-comment-form

		return $fields;
	}

	add_filter('comment_form_default_fields','lbmn_custom_comment_form_fields');
}

if(!function_exists('lbmn_remove_textarea')) {
	function lbmn_remove_textarea($defaults) {
		$defaults['comment_field'] = '';
    	return $defaults;
	}
	if ( ! is_user_logged_in() ) {
		add_filter( 'comment_form_defaults', 'lbmn_remove_textarea' );
	}
}