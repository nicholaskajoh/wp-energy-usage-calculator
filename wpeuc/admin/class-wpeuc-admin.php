<?php

  /**
  * Admin-facing Class
  */
  class WPEUC_Admin extends WPEUC {

    /**
     * Invoke parent's constructor 
     */
    function __construct() {
      parent::__construct();
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

    /**
     * Register settings/options for this plugin
     */
    public function register_and_build_admin_settings() {
      add_settings_section('main_section', self::PLUGIN_NAME . ' Settings', array($this, 'main_settings_section'), $this->settings_page);
      add_settings_field('calc_name', 'Calculator Name:', array($this, 'calc_name_option'), $this->settings_page, 'main_section');
      add_settings_field('calc_desc', 'Calculator Description:', array($this, 'calc_desc_option'), $this->settings_page, 'main_section');
      add_settings_field('calc_instructions', 'Calculator Usage Instructions:', array($this, 'calc_instructions_option'), $this->settings_page, 'main_section');
      register_setting('wpeuc_settings', 'wpeuc_options');
    }

    /**
     * Section for all the settings for this plugin
     */
    public function main_settings_section() {
      echo "<p>Configure you calculator here.</p>";
    }

    /**
     * Calculator name option
     */
    public function calc_name_option() {
      $options =  get_option('wpeuc_options');
      echo "<input class=\"form-control\" name=\"wpeuc_options[calc_name]\" type=\"text\" value=\"{$options['calc_name']}\" /><br>";
    }

    /**
     * Calculator description option
     */
    public function calc_desc_option() {
      $options =  get_option('wpeuc_options');
      echo "<textarea class=\"form-control\" name=\"wpeuc_options[calc_desc]\">{$options['calc_desc']}</textarea><br>";
    }

    /**
     * Calculator usage instructions option
     */
    public function calc_instructions_option() {
      $options =  get_option('wpeuc_options');
      echo "<textarea class=\"form-control\" name=\"wpeuc_options[calc_instructions]\">{$options['calc_instructions']}</textarea><br>";
    }

    /**
     * Validate settings options (no validation done for now)
     */
    public function validate_admin_settings($wpeuc_options) {
      return $wpeuc_options;
    }

    /**
     * Process 'Add Appliance' form
     */
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

        echo "<p class=\"alert alert-success\">New appliance successfully added!</p>";
      }
    }

    /**
     * Process 'Edit Appliance' form
     */
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

        echo "<p class=\"alert alert-success\">Changes saved successfully!</p>";
      }
    }

    /**
     * Delete a given appliance
     */
    public function admin_delete_appliance() {
      global $wpdb;

      if(isset($_POST['delete_appliance'])) {
        $wpdb->delete(
          $this->db_data_table,
          array('id' => $_POST['id'])
        );

        echo "<p class=\"alert alert-success\">Appliance deleted successfully!</p>";
      }
    }

    /**
     * Load static files on the back-end/admin-facing view
     */
    public function enqueue_admin_static() {
      // js
      wp_register_script('wpeuc_admin_js', plugins_url('wpeuc-admin.js', __FILE__), ['jquery'], '0.1.0', true);
      wp_enqueue_script('wpeuc_admin_js');

      // css
      wp_register_style('wpeuc_admin_css', plugins_url('wpeuc-admin.css', __FILE__));
      wp_enqueue_style('wpeuc_admin_css');
    }

  }