<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new Slim\App();

$app->get('/currencies', \CurrencyExchangeExample\Controller\CurrencyController::class . ':getCurrencies');

$app->run();