<?php
return [
    'development' => [
        'master' => [
            'host' => '106.10.43.237'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'dev_barrel'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'slave' => [
            'host' => '106.10.43.237'
            //'host' => '106.10.40.5'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'dev_barrel'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'stat' => [
            'host' => '106.10.43.237'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'dev_barrel'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'sms' => [
            'host' => '101.101.160.234'
            , 'user' => 'barrel_prod'
            , 'pass' => 'barrel!#@$prod'
            , 'name' => 'msg'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
    ],
    'testing' => [
        'master' => [
            'host' => '10.41.179.45'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'dev_barrel'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'slave' => [
            'host' => '10.41.179.45'
            //'host' => '10.41.37.99'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'dev_barrel'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'stat' => [
            'host' => '10.41.179.45'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'dev_barrel'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'sms' => [
            'host' => '10.41.179.45'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'msg'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
    ],
    'production' => [
        'master' => [
            'host' => '10.33.183.53'
            , 'user' => 'barrel_prod'
            , 'pass' => 'barrel!#@$prod'
            , 'name' => 'barrel_mall'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'slave' => [
            'host' => '10.33.183.53'
            , 'user' => 'barrel_prod'
            , 'pass' => 'barrel!#@$prod'
            , 'name' => 'barrel_mall'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'stat' => [
            'host' => '10.33.180.189'
            , 'user' => 'barrel_prod'
            , 'pass' => 'barrel!#@$prod'
            , 'name' => 'barrel_statistics'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'sms' => [
            'host' => '10.41.224.102'
            , 'user' => 'barrel_prod'
            , 'pass' => 'barrel!#@$prod'
            , 'name' => 'msg'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
    ],
    'bizFat' => [
        'master' => [
            'host' => '106.10.43.237'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'barrel_mall_dev'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'slave' => [
            'host' => '106.10.43.237'
            //'host' => '106.10.40.5'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'barrel_mall_dev'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'stat' => [
            'host' => '106.10.43.237'
            , 'user' => 'barrel_dev'
            , 'pass' => 'barrel!#@$dev'
            , 'name' => 'dev_statistics'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
        , 'sms' => [
            'host' => '101.101.160.234'
            , 'user' => 'barrel_prod'
            , 'pass' => 'barrel!#@$prod'
            , 'name' => 'msg'
            , 'port' => '3306'
            , 'char_set' => 'utf8mb4'
            , 'dbcollat' => 'utf8_general_ci'
        ]
    ]
];
