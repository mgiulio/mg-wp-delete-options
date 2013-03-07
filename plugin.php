<?php

/*
Plugin Name: mg WP Delete Options
Plugin URI: http://mgiulio.altervista.org
Description: Add an Ajax delete action to the 'hidden' WP Options page(/wp-admin/options.php)
Version: 0.1
Author: mgiulio (Giulio Mainardi)
Author URI: http://mgiulio.altervista.org
License: GPLv2
*/

require_once 'php/DeleteOptions.php';
new mgDeleteOptions();
