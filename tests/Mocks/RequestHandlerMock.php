<?php

declare(strict_types=1);

namespace Tests\Payourself2\Bundle\MonobankBundle\Mocks;

use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Component\Serializer;
use Payourself2\Bundle\MonobankBundle\Handler\RequestHandler;

class RequestHandlerMock
{
    private Adapter $adapter;

    public function __construct(?Adapter $adapter = null)
    {
        $this->adapter = $adapter ?? new Adapter(null, null);
    }

    public function createMock(): RequestHandler
    {
        $url = 'http://url';
        $sender = new Sender($this->adapter, $url);
        $statusCodeChecker = new StatusCodeChecker();
        $jmsSerializer = new Serializer();

        return new RequestHandler($sender, $statusCodeChecker, $jmsSerializer);
    }
}
