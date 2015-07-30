<?php

if( !class_exists( 'jtFrontend' ) ) {
	class jtFrontend {
	
		public function __construct() {
			add_shortcode( 'medialocations', array( $this, 'media_locations_shortcode' ) );
			add_filter( 'the_content', array( $this, 'empty_paragraph_fix' ) );
		}

		/*
			hat tip: https://thomasgriffin.io/remove-empty-paragraph-tags-shortcodes-wordpress/
		*/
		function empty_paragraph_fix( $content ) {
			$array = array(
				'<p>['    => '[',
				']</p>'   => ']',
				']<br />' => ']'
			);
			return strtr( $content, $array );
		}

		public function query_attachments( $post_id, $location ) {
			$args = array(
				'post_parent' => $post_id,
				'post_type' => 'attachment',
				'post_status' => 'inherit',
				'tax_query' => array(
					array(
						'taxonomy' => 'medialoc',
						'field' => 'slug',
						'terms' => sanitize_title( $location, '', 'query' ),
					)
				),
			);

			return new WP_Query( $args );
		}
		
		public function display_media( $location, $fallback = true, $fallbackhome = false ) {
			global $post;
			ob_start();
			
			$media = $this->query_attachments( $post->ID, $location );

			if ( !$media->have_posts() && $fallback == true ) {
				$media = $this->query_attachments( $post->post_parent, $location );
			}
			if ( !$media->have_posts() && $fallbackhome == true ) {
				$frontpage_id = get_option( 'page_on_front' );
				$media = $this->query_attachments( $frontpage_id, $location );
			}
			
			if ( $media->have_posts() ) {
				while ( $media->have_posts() ) {
					$media->the_post();

					echo wp_get_attachment_image( get_the_ID(), 'full' );
				}
				wp_reset_postdata();
			} else {
				return false;
			}
			
			return ob_get_clean();
		}
		
		public function media_locations_shortcode( $atts ) {
			if ( !isset( $atts['location'] ) )
				return;
			
			return $this->display_media( $atts['location'] );
		}
		
	}
	
	$jtFrontend = new jtFrontend();
}