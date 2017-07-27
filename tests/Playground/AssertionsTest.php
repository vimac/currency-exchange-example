<?php


namespace CurrencyExchangeExample\Tests\Playground;


use CurrencyExchangeExample\Playground\DivisionWorker;
use CurrencyExchangeExample\Playground\ExceptionProducer;
use PHPUnit\Exception;
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
     * @expectedException \PHPUnit\Framework\Error\Warning
     */
    public function testError()
    {
        $worker = new DivisionWorker();
        $actual = $worker->divide(10, 0);
    }

}