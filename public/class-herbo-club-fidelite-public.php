<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       rachidox2k.wordpress.com/
 * @since      1.0.0
 *
 * @package    Herbo_Club_Fidelite
 * @subpackage Herbo_Club_Fidelite/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Herbo_Club_Fidelite
 * @subpackage Herbo_Club_Fidelite/public
 * @author     Rachid El Aissaoui <ra.elaissaoui@gmail.com>
 */
class Herbo_Club_Fidelite_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('init', array($this, 'setup_rewrite'));
		add_action('template_redirect', array($this, 'register_custom_plugin_redirect'));
		add_filter('query_vars', array($this, 'register_query_values'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Herbo_Club_Fidelite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Herbo_Club_Fidelite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/herbo-club-fidelite-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Herbo_Club_Fidelite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Herbo_Club_Fidelite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/herbo-club-fidelite-public.js', array('jquery'), $this->version, false);
	}

	public function setup_rewrite()
	{
		add_rewrite_rule($this->plugin_name, 'index.php?herbo-club-fidelite=index', 'top');
		flush_rewrite_rules();
	}
	public function register_custom_plugin_redirect()
	{
		// Check if we have the custom plugin query, if so lets display the page
		if (get_query_var('herbo-club-fidelite')) {
			add_filter('template_include', function () {
				return plugin_dir_path(__FILE__) . 'partials/herbo-club-fidelite-public-display.php';
			});
		}
	}
	public function register_query_values($vars)
	{
		// Equivalent to array_push($vars, 'custom_plugin', ..)
		$vars[] = 'herbo-club-fidelite';

		return $vars;
	}
}
