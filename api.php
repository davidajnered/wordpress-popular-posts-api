<?php
/*
Plugin Name: Wordpress Popular Posts API
Plugin URI: http://davidajnered.com/wordpress-popular-posts-api
Description: Extends Wordpress Popular Posts with a template API
Version: 1.0
Author: David Ajnered
Author URI: http://davidajnered.com
*/
// namespace WordpressPopularPostsApi;

// Exit if plugin is accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include and init autoloader
require_once(plugin_dir_path(__FILE__) . 'autoloader.php');
autoloader('WordpressPopularPostsApi', 'WPPAPI', 'app');

/**
 *
 */
class WordpressPopularPostsApi
{
    /**
     * var WordpressPopularPostsApi\Core
     */
    private $core;

    public function __construct()
    {
        $this->core = new WordpressPopularPostsApi\Core();
    }

    /**
     * Relay calls to the deeper darks of plugin.
     *
     * @param string $method
     * @param array $args
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->core, $method), $args);
    }
}
