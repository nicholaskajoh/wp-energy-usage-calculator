<?php

  /**
  * Base Plugin Class
  */
  class WPEUC {

    const PLUGIN_NAME = "WP Energy Usage Calculator";
    const PLUGIN_VERSION = "0.1.0";

    protected $plugin_path; // path to plugin                  
    protected $settings_page; // settings page in admin
    public $calc_name; // calculator name -displayed in front-end
    public $calc_desc; // calculator description - displayed in front-end
    public $calc_instructions; // calculator instructions - displayed in front-end
    public $db_data_table; // db table where appliance data is stored
    
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

    /**
     * Add a settings link to plugin page
     */
    public function add_action_links($links) {

      $mylinks = array(
        '<a href="' . admin_url('options-general.php?page=' . $this->settings_page) . '">Settings</a>'
      );

      return array_merge( $links, $mylinks );
    }

    /**
     * Return an instance of appliances in the DB
     */
    public function get_appliances() {
      global $wpdb;

      $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wpeuc_data", OBJECT);
      return $results;
    }

    /**
     * Enqueue vendor scripts/styles
     */
    public function enqueue_general_static() {
      // js
      wp_register_script('bootstrap_js', plugins_url('bootstrap.min.js', __FILE__), ['jquery'], '3.3.7', true);
      wp_enqueue_script('bootstrap_js');

      // css
      wp_register_style('bootstrap_wrapper_css', plugins_url('bootstrap-wrapper.css', __FILE__), [], '0.1.0');
      wp_enqueue_style('bootstrap_wrapper_css');
    }

  }