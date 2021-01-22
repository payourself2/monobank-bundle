<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Tests\Client\General;

use Payourself2\Bundle\MonobankBundle\Action\ResponseDeserializer;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Client\GeneralClient;
use Payourself2\Bundle\MonobankBundle\Exception\TooManyRequestsException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class GeneralClientTest extends TestCase
{
    public function testInvalidStatuses(): void
    {
//        $this->expectException(TooManyRequestsException::class);
//
//        $response = $this->createMock(ResponseInterface::class);
//        $response->method('getStatusCode')->willReturn(429);
//        $adapter = $this->createMock(SendRequestAdapterInterface::class);
//        $adapter->method('send')->willReturn($response);
//
//        $deserializer = new ResponseDeserializer();
//        $statusCodeChecker = new StatusCodeChecker();
//        $monobankApiBasePath = 'http://url';
//
//        $client = new GeneralClient($adapter, $deserializer, $statusCodeChecker, $monobankApiBasePath);
//        iterator_to_array($client->currency());
    }
}

