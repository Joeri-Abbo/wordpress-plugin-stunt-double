<?php
/**
 * Plugin Name: Stunt Double 🚀
 * Description: Add plugin to fake your content. Keep it lazy and typo free
 * Text Domain: stunt-double
 *
 * Author: Joeri Abbo
 * Author URI: https://nl.linkedin.com/in/joeri-abbo-43a457144
 *
 * Version: 1.0.0
 */

// File Security Check
defined('ABSPATH') or die("No script kiddies please!");

define("STUNTDOUBLE_VERSION", 'v1.0.0');
define("STUNTDOUBLE_URI", plugin_dir_url(__FILE__));
define("STUNTDOUBLE_PATH", plugin_dir_path(__FILE__));

const STUNTDOUBLE_TEXT_DOMAIN = 'stunt-double';
require_once STUNTDOUBLE_PATH . 'vendor/autoload.php';

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
class stuntDouble
{

	public const STUNTDOUBLE_TEXT_DOMAIN = 'stunt-double';

	/**
	 * Setup stunt double for faking 🚀
	 */
	public static function init()
	{
		add_action('init', [__CLASS__, 'addTextDomain']);

	}

	public function __construct()
	{
		self::init();
	}

	/**
	 * Add text domain
	 *
	 * @since 1.0.0
	 */
	public static function addTextDomain()
	{
		load_plugin_textdomain(self::STUNTDOUBLE_TEXT_DOMAIN, false, basename(dirname(__FILE__)) . '/languages');
	}
}

new stuntDouble();
