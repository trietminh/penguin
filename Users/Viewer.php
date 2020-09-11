<?php

namespace Penguin\Users;

class Viewer {

	const CLASS_NAME = 'viewer';

	function __construct() {
	}

	static function register_role() {
		return add_role(
			self::CLASS_NAME,
			__( 'Viewer', 'penguin' ),
			array(
				'read'         => true,  // true allows this capability
				'edit_posts'   => false,
				'delete_posts' => false, // Use false to explicitly deny
			)
		);
	}
}