<?php


namespace CurrencyExchangeExample\Playground;


use PHPUnit\Runner\Exception;

class ExceptionProducer
{

    public function produceException()
    {
        //do something

        throw new Exception('hello', 1024);
    }

}