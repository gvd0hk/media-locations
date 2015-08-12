<?php

if( !class_exists( 'jtBackend' ) ) {
	class jtBackend {
	
		public function __construct() {
			add_filter( 'attachment_fields_to_edit', array( $this, 'extra_attachment_fields' ), 10, 2 );
			add_filter( 'attachment_fields_to_save', array( $this, 'extra_attachment_fields_save' ), 10, 2 );
		}

		function extra_attachment_fields( $form_fields, $post ) {
			$form_fields['image_link'] = array(
				'label' => 'Image Link',
				'input' => 'text',
				'value' => get_post_meta( $post->ID, 'image_link', true ),
				'helps' => '',
			);

			return $form_fields;
		}


		function extra_attachment_fields_save( $post, $attachment ) {
			if ( isset( $attachment['image_link'] ) )
				update_post_meta( $post['ID'], 'image_link', $attachment['image_link'] );
			
			return $post;
		}

	}
	
	$jtBackend = new jtBackend();
}