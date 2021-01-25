<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Generator;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyInfo;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyRequest;

class GeneralClient
{
    private Sender $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function currency(): Generator
    {
        $request = new CurrencyRequest();

        $body = $this->sender->send($request);

        foreach ($body as $item) {
            yield new CurrencyInfo(
                $item['currencyCodeA'],
                $item['currencyCodeB'],
                $item['date'],
                $item['rateSell'] ?? null,
                $item['rateBuy'] ?? null,
                $item['rateCross'] ?? null
            );
        }
    }
}
