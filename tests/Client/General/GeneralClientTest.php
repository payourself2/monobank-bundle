<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Tests\Client\General;

use Nyholm\Psr7\Response;
use Payourself2\Bundle\MonobankBundle\Action\ResponseDeserializer;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Client\GeneralClient;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyInfo;
use PHPUnit\Framework\TestCase;

use function fclose;
use function fopen;
use function is_resource;

class GeneralClientTest extends TestCase
{
    private $resource;

    public function testInvalidStatuses(): void
    {
        $response = new Response(200, [], $this->resource);

        $adapter = $this->createMock(SendRequestAdapterInterface::class);
        $adapter->method('send')->willReturn($response);

        $deserializer = new ResponseDeserializer();
        $statusCodeChecker = new StatusCodeChecker();
        $monobankApiBasePath = 'http://url';

        $client = new GeneralClient($adapter, $deserializer, $statusCodeChecker, $monobankApiBasePath);
        $result = iterator_to_array($client->currency());

        self::assertCount(3, $result);
        self::assertContainsOnlyInstancesOf(CurrencyInfo::class, $result);
    }

    protected function setUp(): void
    {
        $this->resource = fopen(__DIR__ . '/../../Fixtures/currency.json', 'r');
    }

    protected function tearDown(): void
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }
}

