<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new Slim\App();
$container = $app->getContainer();
$container['errorHandler'] = function ($c) {
    return function (SLim\Http\Request $request, Slim\Http\Response $response, Exception $exception) use ($c) {
        return $response->withStatus(500)->withJson([
            'code' => $exception->getCode(),
            'msg' => $exception->getMessage(),
            'data' => []
        ]);
    };
};
require __DIR__ . '/../resource/config/dependencies.php';

$app->get('/currencies', \CurrencyExchangeExample\Controller\CurrencyController::class . ':getCurrencies');
$app->get('/exchange', \CurrencyExchangeExample\Controller\CurrencyController::class . ':exchange');

$app->run();