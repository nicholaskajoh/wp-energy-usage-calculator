<?php

  /**
  * Public-facing Class
  */
  class WPEUC_Public extends WPEUC {

    /**
     * Invoke parent's constructor 
     */
    function __construct() {
      parent::__construct();
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
     * Load static files on the front-end/public-facing view
     */
    public function enqueue_public_static() {
      // js
      wp_register_script('wpeuc_public_js', plugins_url('wpeuc-public.js', __FILE__), ['jquery'], '0.1.0', true);
      wp_enqueue_script('wpeuc_public_js');

      // css
      wp_register_style('wpeuc_public_css', plugins_url('wpeuc-public.css', __FILE__));
      wp_enqueue_style('wpeuc_public_css');
    }

  }