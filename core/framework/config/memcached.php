<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Memcached settings
| -------------------------------------------------------------------------
| Your Memcached servers can be specified below.
|
|	See: https://codeigniter.com/user_guide/libraries/caching.html#memcached
|
*/
$config = array(
	'default' => array(
		'hostname' => (defined('MEMCACHED_HOST') ? MEMCACHED_HOST : '127.0.0.1'), // MEMCACHED_HOST
		'port'     => (defined('MEMCACHED_PORT') ? MEMCACHED_PORT : '11211'), // MEMCACHED_PORT
		'weight'   => '1',
	),
);
