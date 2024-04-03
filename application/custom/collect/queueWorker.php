<?php
///////////////////////////////////////////////////
// CLI 환경 설정
///////////////////////////////////////////////////
$_SERVER['HTTP_HOST'] = 'localhost';
defined('HTTP_PROTOCOL') OR define('HTTP_PROTOCOL', 'https');

///////////////////////////////////////////////////
// 수집 환경 설정 파일 로드
///////////////////////////////////////////////////
require_once __DIR__.'/collect.config.php';
///////////////////////////////////////////////////
// 필수 클래스 로드
///////////////////////////////////////////////////
require_once VENDOR_ROOT.'autoload.php';
require_once COLLECT_CLASS_PATH.'CollectReport.class.php';

///////////////////////////////////////////////////
// RabbitMQ 환경 설정 파일 로드
///////////////////////////////////////////////////
if(file_exists(__DIR__.'/queue.worker.config.php')){
    require __DIR__.'/queue.worker.config.php';
}else{
    echo 'worker.config file not found('.__DIR__.'/queue.worker.config.php)';
}


///////////////////////////////////////////////////
// RabbitMQ 접속
///////////////////////////////////////////////////
$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASSWORD, RABBITMQ_VHOST);
$channel    = $connection->channel();

$channel->queue_declare(RQBBITMQ_QUEUE, false, false, false, false);

///////////////////////////////////////////////////
// 통계 리포트 작성
///////////////////////////////////////////////////
$reporter = new CollectReport();

$channel->basic_consume(RQBBITMQ_QUEUE, '', false, true, false, false, function ($msg) use ($reporter) {
    $collectData = json_decode($msg->body, true);
    if (!empty($collectData)) {
        $reporter->setCollectData($collectData)->writeReport();
        print_r($collectData);
    }
});

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();