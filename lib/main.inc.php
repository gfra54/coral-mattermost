<?php

include 'functions.inc.php';

// load current configuration
$config = parse_ini_file(dirname(__FILE__).'/../config.ini');
$GLOBALS['config']=$config;

// get data sent to the webhook
$coral_data = json_decode(@file_get_contents('php://input'),true);


