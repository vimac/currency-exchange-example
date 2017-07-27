<?php

return [
    'mysql:host=localhost;dbname=currency_exchange',
    'currency_exchange',
    '123456',
    [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8mb4',
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
];