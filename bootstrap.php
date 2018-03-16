<?php 
//load config
require_once "config/config.php";
//Load Helper
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';

// load libraries
//auto loader to load libraries and other files

spl_autoload_register(function($className){
	require_once 'libraries/' . $className . '.php';
});
?>