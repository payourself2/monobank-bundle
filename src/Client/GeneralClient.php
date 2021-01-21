<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyInfo;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyRequest;

class GeneralClient
{
    private SendRequestAdapterInterface $adapter;

    private string $monobankApiBasePath;

    public function __construct(
        SendRequestAdapterInterface $adapter,
        string $monobankApiBasePath
    ) {
        $this->adapter = $adapter;
        $this->monobankApiBasePath = $monobankApiBasePath;
    }

    public function currency(): \Generator
    {
        $request = new CurrencyRequest($this->monobankApiBasePath);

        $response = $this->adapter->send($request);
        StatusCodeChecker::check($response->getStatusCode());

        foreach ($response->toArray() as $item) {
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
