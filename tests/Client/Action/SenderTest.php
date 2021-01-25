<?php

declare(strict_types=1);

namespace Client\Action;

use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use Payourself2\Bundle\MonobankBundle\Action\ResponseDeserializer;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyInfo;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class SenderTest extends TestCase
{
    /** @var resource | closed-resource*/
    private $resource;

    public function testNoUrl(): void
    {
        $expectedUrl = 'http://url';
        $expectedPath = '/adds';
        $expected = $expectedUrl.$expectedPath;
        $adapter = $this->createMock(SendRequestAdapterInterface::class);
        $adapter->method('send')->willReturnCallback(function (RequestInterface $request) use($expected){
            self::assertSame($expected, (string)$request->getUri());
            $this->resource = fopen(__DIR__ . '/../../Fixtures/currency.json', 'rb');
            return new Response(200, [], $this->resource);
        });

        $sender = new Sender(
            $adapter,
            $this->createMock(ResponseDeserializer::class),
            $this->createMock(StatusCodeChecker::class),
            $expectedUrl
        );
        $request = new Request( RequestMethod::GET,$expectedPath);
        $sender->send($request);
    }

    public function testWithUrl(): void
    {
        $expectedUrl = 'http://url';
        $expectedPath = '/adds';
        $expected = $expectedUrl.$expectedPath;
        $adapter = $this->createMock(SendRequestAdapterInterface::class);
        $adapter->method('send')->willReturnCallback(function (RequestInterface $request) use($expected){
            self::assertSame($expected, (string)$request->getUri());
            $this->resource = fopen(__DIR__ . '/../../Fixtures/currency.json', 'rb');
            return new Response(200, [], $this->resource);
        });

        $sender = new Sender(
            $adapter,
            $this->createMock(ResponseDeserializer::class),
            $this->createMock(StatusCodeChecker::class),
            'http://url2'
        );
        $request = new Request( RequestMethod::GET, $expected);
        $sender->send($request);
    }

    protected function tearDown(): void
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }
}
