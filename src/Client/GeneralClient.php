<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Handler\RequestHandler;
use Payourself2\Bundle\MonobankBundle\Model\Request\General\CurrencyRequest;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;

class GeneralClient
{
    private RequestHandler $requestHandler;

    public function __construct(RequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    /**
     * @return CurrencyInfo[]
     */
    public function currency(): array
    {
        $request = new CurrencyRequest();

        return $this->requestHandler->handle($request, 'array<' . CurrencyInfo::class . '>');
    }
}
