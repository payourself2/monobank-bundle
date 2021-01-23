<?php

declare(strict_types=1);

namespace Client\Action;

use Nyholm\Psr7\Response;
use Payourself2\Bundle\MonobankBundle\Action\ResponseDeserializer;
use PHPUnit\Framework\TestCase;

use function fopen;

class ResponseDeserializerTest extends TestCase
{
    /** @var resource */
    private $resource;

    public function testWithoutResponse(): void
    {
        $this->resource = fopen('php://temp', 'rb');
        $response = new Response(200, [], $this->resource);

        $deserializer = new ResponseDeserializer();
        $result = $deserializer->deserialise($response);

        self::assertSame([], $result);
    }

    public function testWithResponse(): void
    {
        $this->resource = fopen(__DIR__ . '/../../Fixtures/currency.json', 'rb');
        $response = new Response(200, [], $this->resource);

        $deserializer = new ResponseDeserializer();
        $result = $deserializer->deserialise($response);
        $expected = [
            [
                "currencyCodeA" => 840,
                "currencyCodeB" => 980,
                "date" => 1611353409,
                "rateBuy" => 28.05,
                "rateSell" => 28.3198,
            ],
            [
                "currencyCodeA" => 985,
                "currencyCodeB" => 980,
                "date" => 1611439165,
                "rateBuy" => 7.48,
                "rateSell" => 7.64,
                "rateCross" => 7.64,
            ],
            [
                "currencyCodeA" => 826,
                "currencyCodeB" => 980,
                "date" => 1611439072,
                "rateCross" => 38.903,
            ],
        ];
        self::assertSame($expected, $result);
    }

    protected function tearDown(): void
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }
}
