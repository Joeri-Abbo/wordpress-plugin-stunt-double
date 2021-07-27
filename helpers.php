<?php
/*
 * Helper functions for spaceship
 */

use StuntDouble\StuntDoubleFiller;

if (class_exists('WP_CLI')) {
	/**
	 * The one and only filler we need
	 *
	 * <postType>
	 * : The post_type we want to fill
	 *
	 * --amount=<amount>
	 * : The amount of posts we want to fill. Default 10
	 *
	 * @when before_wp_load
	 */
	WP_CLI::add_command('stuntDouble', function ($args, $assoc_args) {
		try {
			$post_type = $args[0];
			$amount = !empty($assoc_args['amount']) ? $assoc_args['amount'] : 10;
			WP_CLI::line(__('Start stunt double lets start the filling', StuntDouble::STUNTDOUBLE_TEXT_DOMAIN));

			$stuntDouble = new StuntDoubleFiller($post_type, $amount);
			$stuntDouble->startFiller();
			WP_CLI::success(__('Finished with the filling process',
				StuntDouble::STUNTDOUBLE_TEXT_DOMAIN));

		} catch (Exception $e) {
			WP_CLI::error(__('Woops something went wrong.',
				StuntDouble::STUNTDOUBLE_TEXT_DOMAIN));
			\Sentry\captureMessage($e, \Sentry\Severity::error());
		}
	});
}
