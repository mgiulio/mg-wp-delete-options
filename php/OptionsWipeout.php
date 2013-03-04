<?php

require_once 'OptionsWipeoutBase.php';

class mgOptionsWipeout extends mgOptionsWipeoutBase  {

	private $wp_ajax_action = 'mg_wp_options_wipeout';
	private $nonce_action_string = 'mg_wp_options_wipeout_delete';

	function __construct() {
		parent::__construct(array());
		
		if (!is_admin())
			return;
			
		$this->add_action('load-options.php', 'inject_js');
			
		$this->add_action("wp_ajax_{$this->wp_ajax_action}", 'on_ajax_delete');
	}
	
	function inject_js() {
		wp_enqueue_script(
			'mg_wp_options_wipeout_js', 
			"{$this->url['js']}script.js",
			array('jquery'), 
			'', 
			true
		);
		
		$params = array(
			'ajaxEndpoint' => admin_url('admin-ajax.php', isset($_SERVER['HTTPS']) ? 'https' : 'http'),
			'wpAjaxAction' => $this->wp_ajax_action,
			'ajaxSpinnerUrl' => admin_url('images/wpspin_light.gif', isset($_SERVER['HTTPS']) ? 'https' : 'http'),
			'yes' => admin_url('images/yes.png', isset($_SERVER['HTTPS']) ? 'https' : 'http'),
			'no' => admin_url('images/no.png', isset($_SERVER['HTTPS']) ? 'https' : 'http'),
			'nonce' => wp_create_nonce($this->nonce_action_string)
		);
		wp_localize_script('mg_wp_options_wipeout_js', 'mgWpOptionsWipeoutParams', $params);
	}
	
	function on_ajax_delete() {
		//current_user_can
		
		check_ajax_referer($this->nonce_action_string);
		
		$ok = 
			//true
			false
			//delete_option($_REQUEST['option_name'])
		;
		
		if (!$ok)
			header("HTTP/1.0 503 Service Unavailable");
		
		die();
	}
	
}