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
		add_action('wp_ajax_update_points', array($this, 'update_points'));
		add_action('wp_ajax_get_points', array($this, 'get_points'));
		add_action('comment_post', array($this, 'comment_reward'));
		// if (class_exists('woocommerce'))
		add_action('woocommerce_thankyou', array($this, 'order_reward'), 10, 1);
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/herbo-club-fidelite-public.js', array('jquery'), $this->version, true);
		wp_localize_script(
			'herbo-club-fidelite',
			'herbo_club_fidelite',
			array(
				// 'plugin_public_dir' => plugin_dir_url(__FILE__),
				'nonce'				=> wp_create_nonce('herbo_club_nonce'),
				'ajax_url'			=> admin_url('admin-ajax.php'),
				'f_like'			=> intval(get_option('herbo_club_fidelite_f_like')),
				'i_follow'			=> intval(get_option('herbo_club_fidelite_i_follow')),
			)
		);
	}

	public function setup_rewrite()
	{
		add_rewrite_rule($this->plugin_name . '/earn-points', 'index.php?herbo-club-fidelite=earn-points', 'top');
		add_rewrite_rule($this->plugin_name . '/rewards', 'index.php?herbo-club-fidelite=rewards', 'top');
		add_rewrite_rule($this->plugin_name . '/?$', 'index.php?herbo-club-fidelite=index', 'top');
		flush_rewrite_rules();
	}
	public function register_custom_plugin_redirect()
	{
		// Check if we have the custom plugin query, if so lets display the page

		if (get_query_var('herbo-club-fidelite') === 'earn-points')
			add_filter('template_include', function () {
				return plugin_dir_path(__FILE__) . 'partials/herbo-club-fidelite-earn-points.php';
			});
		elseif (get_query_var('herbo-club-fidelite') === 'rewards')
			add_filter('template_include', function () {
				return plugin_dir_path(__FILE__) . 'partials/herbo-club-fidelite-rewards.php';
			});
		elseif (get_query_var('herbo-club-fidelite'))
			add_filter('template_include', function () {
				return plugin_dir_path(__FILE__) . 'partials/herbo-club-fidelite-public-display.php';
			});
	}
	public function register_query_values($vars)
	{
		// Equivalent to array_push($vars, 'custom_plugin', ..)
		$vars[] = 'herbo-club-fidelite';



		return $vars;
	}

	public function update_points()
	{
		if (!(isset($_POST['nonce']) && isset($_POST['earned']) && isset($_POST['p_action']))) {
			status_header(400);
			echo "Something is missing";
			wp_die();
		}
		$p_action = $_POST['p_action'];
		$possible_action = array('f_like', 'i_follow', 'g_review', 'f_share');
		$valid_action = in_array($p_action, $possible_action);
		$is_valid_nonce = wp_verify_nonce($_POST['nonce'], 'herbo_club_nonce');
		if (!$is_valid_nonce || !$valid_action) {
			status_header(400);
			echo 'You are not allowed to send this request';
			wp_die();
		}
		$user_id = get_current_user_id();
		$earned = $_POST['earned'];
		$points = get_user_meta($user_id, 'herbo-club-points', true);
		$points[$p_action]['earned'] = true;
		$old = $points['total_points'];
		$new = $old + intval($earned);
		$points = $this->sanitize_points($old, $new, $points);
		update_user_meta($user_id, 'herbo-club-points', $points);
		echo wp_json_encode($points);
		wp_die();
	}

	public function comment_reward($comment_ID)
	{

		is_user_logged_in() || wp_die();
		$user_id = get_current_user_id();
		$points = get_user_meta($user_id, 'herbo-club-points', true);
		$reward =  intval(get_option('herbo_club_fidelite_c_product'));
		$old = $points['total_points'];
		$new = $old + $reward;
		error_log($new);
		error_log($old);
		$points = $this->sanitize_points($old, $new, $points);
		update_user_meta($user_id, 'herbo-club-points', $points);
	}

	public function order_reward($order_id)
	{


		if (!is_user_logged_in())
			wp_die();
		$order = wc_get_order($order_id);
		$spent = $order->get_total();;
		$earned = intval($spent);
		$user_id = $order->get_user_id();
		$points = get_user_meta($user_id, 'herbo-club-points', true);
		$old = $points['total_points'];
		$new = $old + $earned;
		$points = $this->sanitize_points($old, $new, $points);
		update_user_meta($user_id, 'herbo-club-points', $points);
	}


	public static function get_default_points()
	{
		$initial_status = array(
			'earned'	=> false,
			'claimed'	=> false,
		);
		$initial_reward = array(
			'amount' 	=> 0,
			'coupon'	=> '',
		);
		$points = array(
			'total_points'	=>  intval(get_option('herbo_club_fidelite_n_account')),
			'f_like'		=> $initial_status,
			'f_share'		=> $initial_status,
			'i_follow'		=> $initial_status,
			'g_review'		=> $initial_status,
			'birthay'		=> $initial_status,
			'reward'		=> array(
				'lvl1'	=> $initial_reward,
				'lvl2'	=> $initial_reward,
				'lvl3'	=> $initial_reward,
				'lvl4'	=> $initial_reward,
			)
		);
		return $points;
	}

	public static function get_points()
	{
		$points = array();
		is_user_logged_in() || wp_die();
		$user_id = get_current_user_id();
		if (empty(get_user_meta($user_id, 'herbo-club-points', true))) {
			$points = self::get_default_points();
			add_user_meta($user_id, 'herbo-club-points', $points, true);
		} else {
			$points = get_user_meta($user_id, 'herbo-club-points', true);
		}
		return $points;
	}

	function get_level($points)
	{
		if ($points > 15000)
			$points %= 15000;

		$levels_max = $this->levels_max();
		$level = 0;
		while ($points > $levels_max[$level++]);
		return $level;
	}

	public function sanitize_points($old, $new, $points)
	{
		$old_level = $this->get_level($old);
		$new_level = $this->get_level($new);

		for ($i = $old_level; $i != $new_level; $i++) {
			$points['reward']['lvl' . $i]['amount']++;
			if ($i == 4)
				$i = 0;
		}
		$points['total_points'] = $new % 15000;
		return $points;
	}

	public function levels_max()
	{
		$levels_max = array(1000, 5000, 10000, 15000);

		return $levels_max;
	}
}
