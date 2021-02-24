<?php

declare(strict_types=1);

namespace Client\Action;

use Nyholm\Psr7\Response;
use Payourself2\Bundle\MonobankBundle\Action\ResponseDeserializer;
use PHPUnit\Framework\TestCase;

use function fopen;

class ResponseDeserializerTest extends TestCase
{
    /** @var resource|closed-resource */
    private $resource;

    public function testWithoutResponse(): void
    {
        $this->resource = fopen('php://temp', 'rb');
        $response = new Response(200, [], $this->resource);

        $deserializer = new ResponseDeserializer();
        $result = $deserializer->deserialize($response);

        self::assertSame([], $result);
    }

    public function testWithResponse(): void
    {
        $this->resource = fopen(__DIR__ . '/../../Fixtures/currency.json', 'rb');
        $response = new Response(200, [], $this->resource);

        $deserializer = new ResponseDeserializer();
        $result = $deserializer->deserialize($response);
        $expected = include(__DIR__ . '/../../Fixtures/currencyArray.php');
        self::assertSame($expected, $result);
    }

    protected function tearDown(): void
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }
}
