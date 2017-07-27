<?php


namespace CurrencyExchangeExample\Controller;

use CurrencyExchangeExample\BusinessImpl\CurrencyBusinessImpl;
use CurrencyExchangeExample\Lib\Injectable;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class CurrencyController extends Injectable
{

    public function getCurrencies(Request $request, Response $response)
    {
        $page = $request->getParam('page', 1);

        if (!is_numeric($page) or $page < 1) {
            throw new Exception('page参数不合法');
        }

        /** @var CurrencyBusinessImpl $bizImpl */
        $bizImpl = $this->getContainer()->get('currencyBizImpl');
        $result = $bizImpl->getCurrencies($page);

        return $response->withJson([
            'code' => 0,
            'msg' => 'ok',
            'data' => $result
        ]);
    }

    public function exchange(Request $request, Response $response)
    {
        $from = $request->getParam('from');
        $fromValue = $request->getParam('fromValue');
        $to = $request->getParam('to');

        if (!is_string($from) or strlen($from) >= 4 or strlen($from) < 3) {
            throw new Exception('from参数不合法');
        }
        if (!is_numeric($fromValue) or $fromValue < 0) {
            throw new Exception('fromValue参数不合法');
        }
        if (!is_string($to) or strlen($to) >= 4 or strlen($to) < 3) {
            throw new Exception('to参数不合法');
        }

        $bizImpl = new CurrencyBusinessImpl();
        $toValue = $bizImpl->exchange($from, $fromValue, $to);

        return $response->withJson([
            'code' => 0,
            'msg' => 'ok',
            'data' => [
                'toValue' => $toValue
            ]
        ]);
    }
}