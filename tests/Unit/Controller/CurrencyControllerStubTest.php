<?php


namespace CurrencyExchangeExample\Tests\Unit\Controller;


use CurrencyExchangeExample\BusinessImpl\CurrencyBusinessImpl;
use CurrencyExchangeExample\Controller\CurrencyController;
use Exception;
use PHPUnit\Framework\TestCase;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class CurrencyControllerStubTest extends TestCase
{
    protected function makeBaseRequest()
    {
        $baseRequest = Request::createFromEnvironment(Environment::mock([
            'REQUEST_URI' => '/currencies',
            'QUERY_STRING' => 'page=1'
        ]));

        return $baseRequest;
    }

    /**
     * @return array
     *
     * @dataProvider baseRequestProvider
     */
    public function getCurrenciesRequestProvider()
    {
        $baseRequest = $this->makeBaseRequest();
        return [
            [
                $baseRequest,
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
                $baseRequest->withQueryParams(['page' => 2]),
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

    public function getCurrenciesExceptionRequestProvider()
    {
        $baseRequest = $this->makeBaseRequest();
        return [
            [
                $baseRequest->withQueryParams(['page' => -1]),
                new Response
            ],
            [
                $baseRequest->withQueryParams(['page' => 'hello']),
                new Response
            ],
            [
                $baseRequest->withQueryParams(['page' => null]),
                new Response
            ],
        ];
    }

    /**
     * @param Request $request
     * @param Response $response
     * @expectedException Exception
     * @dataProvider getCurrenciesExceptionRequestProvider
     */
    public function testGetCurrenciesException(Request $request, Response $response)
    {
        $container = new Container();
        $controller = new CurrencyController($container);
        $controller->getCurrencies($request, $response);
    }

}