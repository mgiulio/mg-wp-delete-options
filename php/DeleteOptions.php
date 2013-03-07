<?php

require_once 'DeleteOptionsBase.php';

class mgDeleteOptions extends mgDeleteOptionsBase  {

	private $plugin_prefix;
	private $wp_ajax_action;
	private $nonce_action_string;

	function __construct() {
		parent::__construct(array());
		
		$this->plugin_prefix = strtolower(__CLASS__/*get_class() is fine too*/) . '_';
		$this->wp_ajax_action = $this->plugin_prefix . 'delete';
		$this->nonce_action_string = $this->plugin_prefix . 'delete';
		
		if (!is_admin())
			return;
			
		$this->add_action('admin_bar_menu', 'on_admin_bar_menu');
		$this->add_action('load-options.php', 'inject_js');
		$this->add_action("wp_ajax_{$this->wp_ajax_action}", 'on_ajax_delete');
	}
	
	function on_admin_bar_menu($wp_admin_bar) {
		$wp_admin_bar->add_menu(array(
			'id'    => 'mg_wp_options_wipeout',
			'title' => 'WP Options',
			'href' => admin_url('options.php'),
			'parent' => 'top-secondary'
			)
		);
	}
	
	function inject_js() {
		$js_handle = $this->plugin_prefix . 'js';
		
		wp_enqueue_script(
			$js_handle,
			"{$this->url['js']}script.js",
			array('jquery'), 
			'', 
			true
		);
		
		$params = array(
			'ajaxEndpoint' => admin_url('admin-ajax.php'),
			'wpAjaxAction' => $this->wp_ajax_action,
			'ajaxSpinnerUrl' => admin_url('images/wpspin_light.gif'),
			'yes' => admin_url('images/yes.png'),
			'no' => admin_url('images/no.png'),
			'nonce' => wp_create_nonce($this->nonce_action_string)
		);
		wp_localize_script($js_handle, $this->plugin_prefix . 'args', $params);
	}
	
	function on_ajax_delete() {
		$ok = 
			current_user_can('manage_options') &&
			check_ajax_referer($this->nonce_action_string, '_wpnonce', false) &&
			delete_option($_REQUEST['option_name'])
		;
		
		if (!$ok)
			header("HTTP/1.0 503 Service Unavailable");
		
		die();
	}
	
}