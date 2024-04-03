<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

set_time_limit(3600);

$view = getForbizView(true);

/* @var $cartModel CustomMallCartModel */
$cartModel = $view->import('model.mall.cart');
// 크리마 API 클라이언트
$crema     = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

$rows = $cartModel->getCremaCartInfo();

foreach ($rows as $row) {
    $param = [
        'user_code' => $row['id']
        , 'product_code' => $row['pid']
        , 'code' => $row['cart_ix']
        , 'added_to_cart_at' => $row['regdate']
    ];
    
    $ret = $crema->putCartItem($param);
}
