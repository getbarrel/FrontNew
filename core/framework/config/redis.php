<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | Redis settings
  | -------------------------------------------------------------------------
  | Your Redis servers can be specified below.
  |
  |	See: https://codeigniter.com/user_guide/libraries/caching.html#redis-caching
  |
 */
if (defined('USE_REDIS') && USE_REDIS === true) {
    $config = array(
        'socket_type' => 'tcp', // 'tcp' or 'unix'
        'socket' => '', // in case of `unix` socket type
        'host' => (defined('REDIS_HOST') ? REDIS_HOST : '127.0.0.1'), // REDIS_HOST
        'password' => (defined('REDIS_PASSWORD') ? REDIS_PASSWORD : null), // REDIS_PASSWORD
        'port' => (defined('REDIS_PORT') ? REDIS_PORT : '6379'), // REDIS_PORT
        'timeout' => '0'
    );
}
