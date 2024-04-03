<?php
defined('USE_COLLECT') OR exit('No direct script access allowed');

///////////////////////////////////////////////////
// RabbitMQ 설정 상수
///////////////////////////////////////////////////


if (FORBIZ_BASEURL == 'barrel.devs' || FORBIZ_BASEURL == 'en.barrel.devs' || FORBIZ_BASEURL == 'bizfat.devs' || FORBIZ_BASEURL == 'barrelfrontdev.forbiz.co.kr' || FORBIZ_BASEURL == 'barrelfrontdev.welsoop.co.kr') {
    define('RABBITMQ_HOST', '221.151.188.103');
    define('RABBITMQ_PORT', 5672);
    define('RABBITMQ_USER', 'forbiz');
    define('RABBITMQ_PASSWORD', 'vhqlwm2011');
    define('RABBITMQ_VHOST', 'collectState');
    define('RQBBITMQ_QUEUE', 'collect');
}else if(FORBIZ_BASEURL == 'getbarrel.com' || FORBIZ_BASEURL == 'stg.barrelmade.co.kr' || FORBIZ_BASEURL == 'en.getbarrel.com'){
    define('RABBITMQ_HOST', '10.41.208.247');
    define('RABBITMQ_PORT', 5672);
    define('RABBITMQ_USER', 'barrel');
    define('RABBITMQ_PASSWORD', 'Vhqlwm20!!');
    define('RABBITMQ_VHOST', 'collectState');
    define('RQBBITMQ_QUEUE', 'collect');
}else{
    define('RABBITMQ_HOST', 'slb-3513390.ncloudslb.com');
    define('RABBITMQ_PORT', 5672);
    define('RABBITMQ_USER', 'barrel');
    define('RABBITMQ_PASSWORD', 'Vhqlwm20!!');
    define('RABBITMQ_VHOST', 'collectState');
    define('RQBBITMQ_QUEUE', 'collect');
}

