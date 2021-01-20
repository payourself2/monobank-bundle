<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
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

    public function currency()
    {
        $request = new CurrencyRequest($this->monobankApiBasePath);

        return $this->adapter->send($request);
    }
}
