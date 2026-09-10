<?php
/**
 * Alex Store Theme Functions & Bootstrap
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define Theme Constants
define('ALEX_STORE_VERSION', '1.0.0');
define('ALEX_STORE_DIR', get_template_directory());
define('ALEX_STORE_URI', get_template_directory_uri());

// Load Modular Components from /inc/
require_once ALEX_STORE_DIR . '/inc/setup.php';
require_once ALEX_STORE_DIR . '/inc/enqueue.php';
require_once ALEX_STORE_DIR . '/inc/template-tags.php';
require_once ALEX_STORE_DIR . '/inc/woocommerce.php';
require_once ALEX_STORE_DIR . '/inc/ajax-cart.php';
require_once ALEX_STORE_DIR . '/inc/ajax-search.php';
require_once ALEX_STORE_DIR . '/inc/customizer.php';
