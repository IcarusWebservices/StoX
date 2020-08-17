<?php
require 'includes/navbar.php';
require 'includes/Medoo.php';
require 'includes/html.php';
require 'includes/functions.php';

// Load the config.ini file
if( file_exists('config.ini') ):

$config = parse_ini_file('config.ini');

$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => $config['db_name'],
    'server' => $config['db_host'],
    'username' => $config['db_user'],
    'password' => $config['db_pass']
]);

else:
die;
endif;