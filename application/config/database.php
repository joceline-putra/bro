<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
// 	'hostname' => 'localhost:2233',	
// 	'username' => 'joe',
// 	'password' => '@Master2023',
// 	'database' => 'browlism_studio',
	'hostname' => 'localhost',	
	'username' => 'u3027829_root',
	'password' => '@m45t3rj03',
	'database' => 'u3027829_browlism',	
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	// 'char_set' => 'utf8',
	// 'dbcollat' => 'utf8_general_ci',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_unicode_ci',	
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
