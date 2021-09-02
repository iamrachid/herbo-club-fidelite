<?php

/**
 * the admin-specific functionality of the plugin.
 *
 * @link       rachidox2k.wordpress.com/
 * @since      1.0.0
 *
 * @package    herbo_club_fidelite
 * @subpackage herbo_club_fidelite/admin
 */

/**
 * the admin-specific functionality of the plugin.
 *
 * defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and java_script.
 *
 * @package    herbo_club_fidelite
 * @subpackage herbo_club_fidelite/admin
 * @author     rachid el aissaoui <ra.elaissaoui@gmail.com>
 */
class herbo_club_fidelite_admin
{

	/**
	 * the id of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    the id of this plugin.
	 */
	private $plugin_name;

	/**
	 * the id snake case of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name_snake_case    the id of this plugin in snake case.
	 */
	private $plugin_name_snake_case;

	/**
	 * the version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    the current version of this plugin.
	 */
	private $version;

	/**
	 * initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       the name of this plugin.
	 * @param      string    $version    the version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_name_snake_case = str_replace('-', '_', $this->plugin_name);

		add_action('admin_menu', array($this, 'add_plugin_admin_menu'), 9);
		add_action('admin_init', array($this, 'build_fields'));
	}

	/**
	 * register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * this function is provided for demonstration purposes only.
		 *
		 * an instance of this class should be passed to the run() function
		 * defined in herbo_club_fidelite_loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * the herbo_club_fidelite_loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__file__) . 'css/herbo-club-fidelite-admin.css', array(), $this->version, 'all');
	}

	/**
	 * register the java_script for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * this function is provided for demonstration purposes only.
		 *
		 * an instance of this class should be passed to the run() function
		 * defined in herbo_club_fidelite_loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * the herbo_club_fidelite_loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__file__) . 'js/herbo-club-fidelite-admin.js', array('jquery'), $this->version, false);
	}


	public function add_plugin_admin_menu()
	{
		add_menu_page($this->plugin_name, 'herbo club', 'administrator', $this->plugin_name, array($this, 'display_plugin_admin_menu'), 'dashicons-gift', 26);
	}

	public function display_plugin_admin_menu()
	{
		require_once 'partials/' . $this->plugin_name . '-admin-display.php';
	}

	public function display_plugin_admin_settings()
	{
		// set this var to be used in the settings-display view
		$active_tab = isset($_get['tab']) ? $_get['tab'] : 'general';
		if (isset($_get['error_message'])) {
			add_action('admin_notices', array($this, 'herbo_club_fidelite_settings_messages'));
			do_action('admin_notices', $_get['error_message']);
		}
		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	}
	public function herbo_club_fidelite_settings_messages($error_message)
	{
		switch ($error_message) {
			case '1':
				$message = __('there was an error adding this setting. please try again.  if this persists, shoot us an email.', 'my-text-domain');
				$err_code = esc_attr('herbo_club_fidelite_example_setting');
				$setting_field = 'herbo_club_fidelite_example_setting';
				break;
		}
		$type = 'error';
		add_settings_error(
			$setting_field,
			$err_code,
			$message,
			$type
		);
	}
	public function build_fields()
	{
		/**
		 * first, we add_settings_section. this is necessary since all future settings must belong to one.
		 * second, add_settings_field
		 * third, register_setting
		 */
		add_settings_section(
			// id used to identify this section and with which to register options
			'herbo_club_fidelite_general_section',
			// title to be displayed on the administration page
			'',
			// callback used to render the description of the section
			array($this, 'herbo_club_fidelite_display_general_account'),
			// page on which to add this section of options
			'herbo_club_fidelite_general_settings'
		);
		$fields = array(
			'n_account' => "Creation d'un compte",
			'f_like' => 'Facebook page like',
			'c_product' => 'Commentaire sur produit',
			'i_follow' => 'Instagram suivre',
			'g_review' => 'Noter 5 * sur Google Review',
			'f_share' => 'Partager notre site sur facebook',
			'birthay' => 'Anniversaire',
		);

		foreach ($fields as $id => $title) {
			$this->and_register_fields($id, $title);
		}
	}

	private function and_register_fields($id, $title)
	{
		$args = array(
			'type'      => 'input',
			'subtype'   => 'text',
			'id'    => $this->plugin_name_snake_case . '_' . $id,
			'name'      => $this->plugin_name_snake_case . '_' . $id,
			'required' => 'true',
			'get_options_list' => '',
			'value_type' => 'normal',
			'wp_data' => 'option'
		);
		add_settings_field(
			$this->plugin_name_snake_case . '_' . $id,
			$title,
			array($this, 'herbo_club_fidelite_render_settings_field'),
			'herbo_club_fidelite_general_settings',
			'herbo_club_fidelite_general_section',
			$args
		);


		register_setting(
			'herbo_club_fidelite_general_settings',
			$this->plugin_name_snake_case . '_' . $id
		);
	}


	public function herbo_club_fidelite_display_general_account()
	{
		echo '<p>Settings</p>';
	}
	public function herbo_club_fidelite_render_settings_field($args)
	{

		if (empty(get_option($args['name'])))
			update_option($args['name'], $this->herbo_club_fidelite_default_settings($args['name']));
		$wp_data_value = get_option($args['name']);
		echo  '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '"  name="' . $args['name'] . ' " size="40" " value="' . $wp_data_value . '" />';
	}


	private function herbo_club_fidelite_default_settings($id)
	{

		$default_options = array(
			$this->plugin_name_snake_case . '_n_account' => 50,
			$this->plugin_name_snake_case . '_f_like' => 50,
			$this->plugin_name_snake_case . '_c_product' => 50,
			$this->plugin_name_snake_case . '_i_follow' => 100,
			$this->plugin_name_snake_case . '_g_review' => 100,
			$this->plugin_name_snake_case . '_f_share' => 100,
			$this->plugin_name_snake_case . '_birthay' => 500
		);
		return $default_options[$id];
	}
}
