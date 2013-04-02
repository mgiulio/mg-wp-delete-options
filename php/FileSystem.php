<?php

class mgFileSystem {

	private static $the_instance;
	
	private $url = array();
	private $path = array();

	private function __construct() {
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
	
	function get_js_url($script) {
		return $this->url['js'] . $script . '.js';
	}
	
	static function get_instance() {
		if (!self::$the_instance)
			self::$the_instance = new self;
		return self::$the_instance;
	}
	
}