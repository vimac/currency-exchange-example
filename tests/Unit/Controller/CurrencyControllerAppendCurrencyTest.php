<?php


namespace CurrencyExchangeExample\Tests\Unit\Controller;


use CurrencyExchangeExample\BusinessImpl\CurrencyBusinessImpl;
use CurrencyExchangeExample\Controller\CurrencyController;
use PHPUnit\Framework\TestCase;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class CurrencyControllerAppendCurrencyTest extends TestCase
{
    protected function makeBaseRequest()
    {
        $baseRequest = Request::createFromEnvironment(Environment::mock([
            'REQUEST_URI' => '/append',
        ]));

        return $baseRequest;
    }

    public function appendDataProvider()
    {
        $request = $this->makeBaseRequest();

        return [
            [
                $request->withQueryParams(['name' => 'jpy', 'base' => 1655]),
                new Response(),
            ]
        ];
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @dataProvider appendDataProvider
     */
    public function testAppend(Request $request, Response $response)
    {
        $container = new Container();
        $mock = $this->createMock(CurrencyBusinessImpl::class);
        $mock->expects($this->once())
            ->method('append')
            ->willReturn(true);
        $container['currencyBizImpl'] = $mock;

        $controller = new CurrencyController($container);

        $result = $controller->append($request, $response);
        $this->assertInstanceOf(Response::class, $response);

        $responseBody = $result->getBody();
        $responseBody->rewind();

        $responseJson = json_decode($responseBody->getContents(), true);

        $this->assertTrue($responseJson['data']['result']);
    }

    public function appendExceptionDataProvider()
    {
        $request = $this->makeBaseRequest();

        return [
            [
                $request->withQueryParams(['name' => 'jpy', 'base' => -1]),
                new Response(),
                '不合法的base'
            ],
            [
                $request->withQueryParams(['name' => '', 'base' => 100]),
                new Response(),
                '不合法的name'
            ],
            [
                $request->withQueryParams(['name' => 'jpy', 'base' => 0]),
                new Response(),
                '不合法的base'
            ],
            [
                $request->withQueryParams(['name' => 'helloWorld', 'base' => 100]),
                new Response(),
                '不合法的name'
            ],
        ];
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $expectMessage
     *
     * @dataProvider appendExceptionDataProvider
     */
    public function testAppendException(Request $request, Response $response, $expectMessage)
    {
        $container = new Container();
        $controller = new CurrencyController($container);

        $this->expectExceptionMessage($expectMessage);
        $response = $controller->append($request, $response);
    }

}