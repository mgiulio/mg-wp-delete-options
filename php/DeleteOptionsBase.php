<?php

class mgDeleteOptionsBase {

	protected $plugin_prefix;
	protected $url;
	protected $path;

	function __construct($cfg) {
		$this->plugin_prefix = strtolower(get_class($this)) . '_';
		
		$this->setup_paths_and_urls();
	}
	
	protected function setup_paths_and_urls() {
		$d = dirname(__FILE__);
		$pdu = plugin_dir_url($d);
		$pdp = plugin_dir_path($d);
		
		$this->url = array(
			'plugin' => $pdu,
			'js' => "{$pdu}js/"
		);
		$this->path = array(
			'plugin' => $pdp
		);
	}
	
	protected function add_action($wp_action_string, $method, $priority = 10, $accepted_args = 1) {
		add_action($wp_action_string, array($this, $method), $priority, $accepted_args);
	}
	
	protected function is_ajax_request($action) {
		return
			defined('DOING_AJAX' ) && 
			DOING_AJAX &&
			!empty($_REQUEST['action']) &&
			$_REQUEST['action'] === $action
		;
	}
	
}