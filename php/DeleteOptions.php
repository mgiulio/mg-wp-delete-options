<?php

require_once 'DeleteOptionsBase.php';

class mgDeleteOptions extends mgDeleteOptionsBase  {

	private $wp_ajax_action;
	private $nonce_action_string;

	function __construct() {
		parent::__construct(array());
		
		$this->add_action('admin_init', 'init');
	}
	
	function init() {
		if (!current_user_can('manage_options'))
			return;
			
		$this->wp_ajax_action = $this->plugin_prefix . 'delete';
		$this->nonce_action_string = $this->plugin_prefix . 'delete';
			
		if ($this->is_ajax_request($this->wp_ajax_action)) {
			$this->add_action("wp_ajax_{$this->wp_ajax_action}", 'on_ajax_delete');
		}
		else {
			$this->add_action('admin_bar_menu', 'on_admin_bar_menu');
			$this->add_action('load-options.php', 'inject_js');
		}
	}
	
	protected function is_ajax_request($action) {
		return
			defined('DOING_AJAX' ) && 
			DOING_AJAX &&
			!empty($_REQUEST['action']) &&
			$_REQUEST['action'] === $action
		;
	}
	
	function on_admin_bar_menu($wp_admin_bar) {
		$wp_admin_bar->add_menu(array(
			'id'    => 'mg_wp_delete_options_hidden_page',
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
			'yesBtnUrl' => admin_url('images/yes.png'),
			'noBtnUrl' => admin_url('images/no.png'),
			'nonce' => wp_create_nonce($this->nonce_action_string)
		);
		wp_localize_script($js_handle, $this->plugin_prefix . 'args', $params);
	}
	
	function on_ajax_delete() {
		$ok = 
			//Already tested! current_user_can('manage_options') &&
			check_ajax_referer($this->nonce_action_string, '_wpnonce', false) &&
			delete_option($_POST['option_name'])
		;
		
		if (!$ok)
			wp_send_json_error();
		else
			wp_send_json_success();
	}
	
}