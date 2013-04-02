<?php

class mgDeleteOptionsBase {

	protected $plugin_prefix;

	function __construct($cfg) {
		$this->plugin_prefix = strtolower(get_class($this)) . '_';
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
	
	protected function inject_js($script, $params = array()) {
		$js_handle = $this->plugin_prefix . $script . '_js';
		
		require_once 'FileSystem.php';
		wp_enqueue_script(
			$js_handle,
			mgFileSystem::get_instance()->get_js_url($script),
			array('jquery'), 
			'', 
			true
		);
		
		if (!empty($params))
			wp_localize_script($js_handle, $this->plugin_prefix . 'args', $params);
	}
	
}