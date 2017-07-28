<?php


namespace CurrencyExchangeExample\Tests\Playground;


use CurrencyExchangeExample\Playground\DivisionWorker;
use CurrencyExchangeExample\Playground\ExceptionProducer;
use Exception;
use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;

class AssertionsTest extends TestCase
{

    public function testAssertObject()
    {
        $obj = new \stdClass();
        $this->assertInstanceOf(\stdClass::class, $obj);
    }

    public function testAssertTypes()
    {
        $input = [];

        $this->assertInternalType('array', $input);

        $input = ['hello' => 'world'];

        $this->assertArrayHasKey('hello', $input);
    }

    public function testException()
    {
        $producer = new ExceptionProducer();

        $this->expectException(Exception::class);
        $producer->produceException();
    }

    public function testDivision()
    {
        $worker = new DivisionWorker();
        $actual = $worker->divide(10, 5);

        $this->assertEquals(2, $actual);
    }

    /**
     *
     */
    public function testError()
    {
        $worker = new DivisionWorker();
        $this->expectException(\PHPUnit\Framework\Error\Notice::class);
        $actual = $worker->divide(10, 0);
        $this->assertEquals(0, $actual);
    }

}