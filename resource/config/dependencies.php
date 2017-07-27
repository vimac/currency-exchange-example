<?php

$container = $app->getContainer();

$container['currencyBizImpl'] = function($container) {
    return new \CurrencyExchangeExample\BusinessImpl\CurrencyBusinessImpl($container);
};

$container['db'] = function($container) {
    list($dsn, $username, $password, $config) = (require __DIR__ . '/database.php');
    return new PDO($dsn, $username, $password, $config);
};