<?php


namespace CurrencyExchangeExample\Playground;


use Exception;

class ExceptionProducer
{

    public function produceException()
    {
        //do something

        throw new MyException1('hello', 1024);
    }

}

class MyException1 extends Exception
{

}

class MyException2 extends Exception
{

}