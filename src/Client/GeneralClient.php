<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Generator;
use Payourself2\Bundle\MonobankBundle\Action\ResponseDeserializer;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyInfo;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyRequest;

class GeneralClient
{
    private SendRequestAdapterInterface $adapter;

    private ResponseDeserializer $deserializer;

    private StatusCodeChecker $statusCodeChecker;

    private string $monobankApiBasePath;

    public function __construct(
        SendRequestAdapterInterface $adapter,
        ResponseDeserializer $deserializer,
        StatusCodeChecker $statusCodeChecker,
        string $monobankApiBasePath
    ) {
        $this->adapter = $adapter;
        $this->deserializer = $deserializer;
        $this->statusCodeChecker = $statusCodeChecker;
        $this->monobankApiBasePath = $monobankApiBasePath;
    }

    public function currency(): Generator
    {
        $request = new CurrencyRequest($this->monobankApiBasePath);

        $response = $this->adapter->send($request);
        $this->statusCodeChecker->check($response);
        $body = $this->deserializer->deserialise($response, 'array<' . CurrencyInfo::class . '>');

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
