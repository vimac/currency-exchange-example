<?php


namespace CurrencyExchangeExample\Tests\Playground;


use CurrencyExchangeExample\Playground\PlusWorker;
use PHPUnit\Framework\TestCase;

class DependsTest extends TestCase
{
    private $test = 1;

    public function testA()
    {
        $this->assertInternalType('int', 1);

        return 1;
    }

    public function testB()
    {
        $this->assertInternalType('int', 2);

        return 2;
    }


    /**
     * @param $a
     * @param $b
     * @depends testA
     * @depends testB
     * $depends produceResult
     */
    public function testPlus($a, $b)
    {
        $expect = $a + $b;

        $worker = new PlusWorker();
        $actual = $worker->plusAB($a, $b);

        $this->assertEquals($expect, $actual);
    }

}