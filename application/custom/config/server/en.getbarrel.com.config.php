<?php
defined('MALL_ID') OR define('MALL_ID', 'barrel');
defined('MALL_IX') OR define('MALL_IX', '20bd04dac38084b2bafdd6d78cd596b2');
defined('DOMAIN_LICENSE') OR define('DOMAIN_LICENSE', '39980e248de66ca25c15fd99c4ce04bd');

defined('MALL_TEMPLATE') OR define('MALL_TEMPLATE', 'enterprise');
defined('MALL_MOBILE_TEMPLATE') OR define('MALL_MOBILE_TEMPLATE', 'mobile_enterprise');

defined('BASIC_LANGUAGE') OR define('BASIC_LANGUAGE', 'english');

//DB_CONNECTION_DIV : development,testing,production...
defined('DB_CONNECTION_DIV') OR define('DB_CONNECTION_DIV', 'production');

define('SESSION_INTEGRATION', true);

//글로벌 관련 설정
define('BCSCALE', 2);
define('TBL_SHOP_PRODUCT', 'shop_product_global');
define('TBL_SHOP_PRODUCT_OPTIONS', 'shop_product_options_global');
define('TBL_SHOP_PRODUCT_OPTIONS_DETAIL', 'shop_product_options_detail_global');

define('FRONT_UNIT','$');
define('BACK_UNIT','');

//Shared cache
define('USE_SHARED_CACHE', true);
