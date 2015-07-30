<?php

if( !class_exists( 'jtTaxonomies' ) ) {
	class jtTaxonomies {
	
		public function __construct() {
			add_action( 'init', array( $this, 'media_location_taxonomy' ) );
		}

		public function media_location_taxonomy() {
			$singular = "Location";
			$plural = "Locations";
			
			$labels = array(
				'name'                => _x( $plural, 'taxonomy general name' ),
				'singular_name'       => _x( $singular, 'taxonomy singular name' ),
				'search_items'        => __( 'Search ' . $plural ),
				'all_items'           => __( 'All ' . $plural ),
				'parent_item'         => __( 'Parent ' . $singular ),
				'parent_item_colon'   => __( 'Parent ' . $singular . ':' ),
				'edit_item'           => __( 'Edit ' . $singular ), 
				'update_item'         => __( 'Update ' . $singular ),
				'add_new_item'        => __( 'Add New ' . $singular ),
				'new_item_name'       => __( 'New '. $singular .' Name' ),
				'menu_name'           => __( $plural )
			); 	
			register_taxonomy(
				'medialoc',
				'attachment',
				array(
					'label' => __( $plural ),
					'labels' => $labels,
					'sort' => true,
					'hierarchical' => true,
					'show_admin_column' => true
				)
			);
		}

	}
	
	$jtTaxonomies = new jtTaxonomies();
}