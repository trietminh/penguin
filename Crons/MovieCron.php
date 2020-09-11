<?php

namespace Penguin\Crons;

use Penguin\Users\Viewer;

class MovieCron {

	function __construct() {

	}

	static function penguin_sendmail_cron() {

		$args  = array(
			'role' => Viewer::CLASS_NAME,
		);
		$users = get_users( $args );

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				wp_mail( $user->user_email, 'News of the jungle', 'Something happening somewhere' );
			}
		}
	}
}