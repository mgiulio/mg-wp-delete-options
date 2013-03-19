<?php

/*
Plugin Name: mg WP Delete Options
Plugin URI: http://mgiulio.altervista.org
Description: A WordPress plugin to delete with Ajax the options in the 'hidden' WP Options page(/wp-admin/options.php)
Version: 0.1
Author: mgiulio (Giulio Mainardi)
Author URI: http://mgiulio.altervista.org
License: GPLv2
*/

require_once 'php/DeleteOptions.php';
new mgDeleteOptions();
