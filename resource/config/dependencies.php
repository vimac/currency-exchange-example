<?php

$container = $app->getContainer();

$container['currencyBizImpl'] = function($container) {
    return new \CurrencyExchangeExample\BusinessImpl\CurrencyBusinessImpl($container);
};