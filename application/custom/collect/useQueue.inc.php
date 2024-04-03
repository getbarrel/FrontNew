<?php
defined('USE_COLLECT') OR exit('No direct script access allowed');
defined('VENDOR_ROOT') OR exit('No direct script access allowed(VENDOR_ROOT)');
defined('COLLECT_CLASS_PATH') OR exit('No direct script access allowed(COLLECT_CLASS_PATH)');

///////////////////////////////////////////////////
// RabbitMQ 환경 설정 파일 로드
///////////////////////////////////////////////////
require __DIR__ . '/queue.collect.config.php';

///////////////////////////////////////////////////
// 필수 클래스 로드
///////////////////////////////////////////////////
require_once VENDOR_ROOT.'autoload.php';
require_once COLLECT_CLASS_PATH.'CollectVisit.class.php';

///////////////////////////////////////////////////
// 통계 정보 수집
///////////////////////////////////////////////////
$collecter = new CollectVisit();
$collecter->collectVisitData();


///////////////////////////////////////////////////
// RabbitMQ 접속
///////////////////////////////////////////////////
$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASSWORD, RABBITMQ_VHOST);
$channel    = $connection->channel();
$channel->queue_declare(RQBBITMQ_QUEUE, false, false, false, false);

///////////////////////////////////////////////////
// 정보 수집, 등록
///////////////////////////////////////////////////
$msg = new \PhpAmqpLib\Message\AMQPMessage(json_encode($collecter->getCollectData()));
$channel->basic_publish($msg, '', RQBBITMQ_QUEUE);
