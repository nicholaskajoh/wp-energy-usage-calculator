<?php

	/**
	* Main plugin class
	*/
	class WPEUC {

		const PLUGIN_NAME = "WP Energy Usage Calculator";
		const PLUGIN_VERSION = "0.1.0";

		private $plugin_path;
		private $settings_page;
		public $calc_name;
		public $calc_desc;
		public $calc_instructions;
		public $db_data_table;
		
		function __construct() {
			global $wpdb;

			$this->plugin_path = plugin_dir_path( __FILE__ );
			$this->settings_page = "wpeuc-settings";
			$this->calc_name = get_option('wpeuc_options')['calc_name'];
			$this->calc_desc = get_option('wpeuc_options')['calc_desc'];
			$this->calc_instructions = get_option('wpeuc_options')['calc_instructions'];
			$this->db_data_table = $wpdb->prefix . "wpeuc_data";
		}

		/**
		 * Do this when this plugin is activated
		 */
		public function activate() {
			// create appliance table
			global $wpdb;

			$table_name = $this->db_data_table;
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`appliance_name` varchar(50) NOT NULL,
				`power_rating` decimal(10, 2) NOT NULL,
				`average_daily_usage` decimal(10, 2) NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}

		/**
		 * Do this when this plugin is deactivated
		 */
		public function deactivate() {
			// deactivate plugin
		}

		/**
		 * Do this when this plugin is deleted
		 */
		public function uninstall() {
			global $wpdb;

    		$wpdb->query("DROP TABLE IF EXISTS " . $this->db_data_table);
		}

		public function add_action_links($links) {

			$mylinks = array(
				'<a href="' . admin_url('options-general.php?page=' . $this->settings_page) . '">Settings</a>'
			);

			return array_merge( $links, $mylinks );
		}

		public function get_appliances() {
			global $wpdb;

			$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wpeuc_data", OBJECT);
			return $results;
		}

		/**
		 * Hook public view to WP 
		 */
		public function get_public_view() {
			// calculator short code
			add_shortcode('wpeuc', array($this, 'public_view'));
		}

		/**
		 * Load public view
		 */
		public function public_view() {
			// CALCULATOR
			// template
			require $this->plugin_path . "public/wpeuc-public-view.php";
		}

		/**
		 * Hook admin view to WP
		 */
		public function get_admin_view() {
			add_options_page(self::PLUGIN_NAME . ' Options', self::PLUGIN_NAME, 'manage_options', $this->settings_page, array($this, 'admin_view'));
		}

		/**
		 * Load admin view
		 */
		public function admin_view() {
			// ADMIN SETTINGS
			//template
			require $this->plugin_path . "admin/wpeuc-admin-view.php";
		}

		public function register_and_build_admin_settings() {
			add_settings_section('main_section', self::PLUGIN_NAME . ' Settings', array($this, 'main_settings_section'), $this->settings_page);
			add_settings_field('calc_name', 'Calculator Name:', array($this, 'calc_name_option'), $this->settings_page, 'main_section');
			add_settings_field('calc_desc', 'Calculator Description:', array($this, 'calc_desc_option'), $this->settings_page, 'main_section');
			add_settings_field('calc_instructions', 'Calculator Instructions:', array($this, 'calc_instructions_option'), $this->settings_page, 'main_section');
			register_setting('wpeuc_settings', 'wpeuc_options');
		}

		public function main_settings_section() {
			echo "<p>Configure you calculator here.</p>";
		}

		public function calc_name_option() {
			$options =  get_option('wpeuc_options');
			echo "<input name=\"wpeuc_options[calc_name]\" type=\"text\" value=\"{$options['calc_name']}\" />";
		}

		public function calc_desc_option() {
			$options =  get_option('wpeuc_options');
			echo "<textarea name=\"wpeuc_options[calc_desc]\">{$options['calc_desc']}</textarea>";
		}

		public function calc_instructions_option() {
			$options =  get_option('wpeuc_options');
			echo "<textarea name=\"wpeuc_options[calc_instructions]\">{$options['calc_instructions']}</textarea>";
		}

		public function validate_admin_settings($wpeuc_options) {
			return $wpeuc_options;
		}

		public function admin_add_appliance() {
			global $wpdb;

			if(isset($_POST['add_appliance'])) {
				$wpdb->insert(
					$this->db_data_table,
					array(
						'appliance_name' => $_POST['appliance_name'],
						'power_rating' => $_POST['power_rating'],
						'average_daily_usage' => $_POST['average_daily_usage']
					),
					array(
						'%s',
						'%f',
						'%f'
					)
				);

				echo "<p class=\"notice notice-success wpeuc-notice\">New appliance successfully added!</p>";
			}
		}

		public function admin_edit_appliance() {
			global $wpdb;

			if(isset($_POST['edit_appliance'])) {
				$wpdb->update(
					$this->db_data_table,
					array(
						'appliance_name' => $_POST['appliance_name'],
						'power_rating' => $_POST['power_rating'],
						'average_daily_usage' => $_POST['average_daily_usage']
					),
					array('id' => $_POST['id']),
					array(
						'%s',
						'%f',
						'%f'
					)
				);

				echo "<p class=\"notice notice-success wpeuc-notice\">Changes saved successfully!</p>";
			}
		}

		public function admin_delete_appliance() {
			global $wpdb;

			if(isset($_POST['delete_appliance'])) {
				$wpdb->delete(
					$this->db_data_table,
					array('id' => $_POST['id'])
				);

				echo "<p class=\"notice notice-success wpeuc-notice\">Appliance deleted successfully!</p>";
			}
		}

		/**
		 * Load static files on the front-end
		 */
		public function enqueue_public_static() {
			// js
			wp_register_script('wpeuc_public_js', plugins_url('public/js/wpeuc-public.js', __FILE__), ['jquery'], '0.1.0', true);
			wp_enqueue_script('wpeuc_public_js');

			// css
			wp_register_style('wpeuc_public_css', plugins_url('public/css/wpeuc-public.css', __FILE__));
			wp_enqueue_style('wpeuc_public_css');
		}		

		/**
		 * Load static files on the back-end
		 */
		public function enqueue_admin_static() {
			// js
			wp_register_script('wpeuc_admin_js', plugins_url('admin/js/wpeuc-admin.js', __FILE__), ['jquery'], '0.1.0', true);
			wp_enqueue_script('wpeuc_admin_js');

			// css
			wp_register_style('wpeuc_admin_css', plugins_url('admin/css/wpeuc-admin.css', __FILE__));
			wp_enqueue_style('wpeuc_admin_css');
		}
	}