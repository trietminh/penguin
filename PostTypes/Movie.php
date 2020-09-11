<?php

namespace Penguin\PostTypes;

class Movie {

	const CLASS_NAME = 'movie';

	function __construct() {
		// register post type
		$this->register_post_type();

		// filter title
		add_filter( 'the_title', array( $this, 'filter_title' ), 10, 2 );
	}

	function register_post_type() {
		register_post_type( $this::CLASS_NAME,
			array(
				'labels'             => array(
					'name'          => __( 'Movies', 'penguin' ),
					'singular_name' => __( 'Movie', 'penguin' ),
				),
				'public'             => true,
				'menu_icon'          => 'dashicons-format-video',
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => $this::CLASS_NAME ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			)
		);
	}

	function filter_title( $title, $id ) {
		$current_post = get_post( $id );
		if ( ! empty( $current_post ) && self::CLASS_NAME == $current_post->post_type && ! is_admin() ) {
			$title = $title . '-Upcoming this year';
		}

		return $title;
	}
}