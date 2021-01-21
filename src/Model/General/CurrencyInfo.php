<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\General;

use DateTime;

/**
 * @psalm-immutable
 */
class CurrencyInfo
{
    public int $currencyCodeA;

    public int $currencyCodeB;

    public Datetime $date;

    public ?float $rateSell;

    public ?float $rateBuy;

    public ?float $rateCross;

    public function __construct(
        int $currencyCodeA,
        int $currencyCodeB,
        int $timestamp,
        ?float $rateSell,
        ?float $rateBuy,
        ?float $rateCross
    ) {
        $this->currencyCodeA = $currencyCodeA;
        $this->currencyCodeB = $currencyCodeB;
        $this->date = new DateTime("@{$timestamp}");
        $this->rateSell = $rateSell;
        $this->rateBuy = $rateBuy;
        $this->rateCross = $rateCross;
    }
}
