<?php


namespace CurrencyExchangeExample\Lib;


use Psr\Container\ContainerInterface;

class Injectable
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

}