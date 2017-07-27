<?php


namespace CurrencyExchangeExample\Tests\Playground;


use CurrencyExchangeExample\Playground\PlusWorker;
use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{

    public function produceDataArray()
    {
        return [
            [1,2,3],
            [2,2,4],
            [3,3,6]
        ];
    }

    /**
     * @param $a
     * @param $b
     * @param $expect
     *
     * @dataProvider produceDataArray
     */
    public function testPlus($a, $b, $expect)
    {
        $worker = new PlusWorker();
        $actual = $worker->plusAB($a, $b);

        $this->assertEquals($expect, $actual);
    }

}