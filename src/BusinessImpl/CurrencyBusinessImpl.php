<?php


namespace CurrencyExchangeExample\BusinessImpl;


use CurrencyExchangeExample\Lib\Injectable;
use PDO;

class CurrencyBusinessImpl extends Injectable
{

    public function getCurrencies($page)
    {
        $pageSize = 3;
        /** @var PDO $pdo */
        $pdo = $this->getContainer()->get('db');
        $st = $pdo->prepare('select `name`,`base` from `currencies` limit ?,?');
        $st->bindValue(1, ($page - 1) * $pageSize, PDO::PARAM_INT);
        $st->bindValue(2, $pageSize, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchAll();

        return $result;
    }

    public function exchange($fromCurrency, $fromValue, $toCurrency)
    {
        $fromBase = 0;
        $toBase = 0;

        /** @var PDO $pdo */
        $pdo = $this->getContainer()->get('db');
        $st = $pdo->prepare('select `name`, `base` from `currencies` where `name` in (?,?)');
        $st->bindValue(1, $fromCurrency);
        $st->bindValue(2, $toCurrency);
        $st->execute();
        $result = $st->fetchAll();

        foreach ($result as $item) {
            if ($item['name'] == $fromCurrency) {
                $fromBase = $item['base'];
            }
            if ($item['name'] == $toCurrency) {
                $toBase = $item['base'];
            }
        }

        $toValue = $fromValue * ($toBase / $fromBase);

        return $toValue;
    }

    public function append($name, $base)
    {
    }

}