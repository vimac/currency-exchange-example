<?php


namespace CurrencyExchangeExample\Tests\Unit\Controller;


use CurrencyExchangeExample\BusinessImpl\CurrencyBusinessImpl;
use CurrencyExchangeExample\Controller\CurrencyController;
use PHPUnit\Framework\TestCase;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class CurrencyControllerTest extends TestCase
{

    public function getCurrenciesRequestProvider()
    {
        $request = Request::createFromEnvironment(Environment::mock([
                'REQUEST_URI' => '/currencies',
                'QUERY_STRING' => 'page=1'
            ]));
        return [
            [
                $request,
                new Response(),
                [
                    [
                        'name' => 'rmb',
                        'base' => 100
                    ],
                    [
                        'name' => 'usd',
                        'base' => 14
                    ]
                ]
            ],
            [
                $request->withQueryParams(['page' => 2]),
                new Response(),
                []
            ]
        ];
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array|null $stubExpectReturn
     *
     * @dataProvider getCurrenciesRequestProvider
     */
    public function testGetCurrencies(Request $request, Response $response, array $stubExpectReturn = null)
    {
        $stub = $this->createMock(CurrencyBusinessImpl::class);
        $stub->method('getCurrencies')->willReturn($stubExpectReturn);

        $container = new Container();
        $container['currencyBizImpl'] = $stub;

        $controller = new CurrencyController($container);

        /** @var Response $result */
        $result = $controller->getCurrencies($request, $response);
        $this->assertInstanceOf(Response::class, $result);

        $responseBody = $result->getBody();
        $responseBody->rewind();

        $responseJson = json_decode($responseBody->getContents(), true);

        $this->assertEquals($stubExpectReturn, $responseJson['data']);
    }

}