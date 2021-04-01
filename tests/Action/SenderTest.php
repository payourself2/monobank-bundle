<?php

declare(strict_types=1);

namespace Tests\Payourself2\Bundle\MonobankBundle\Action;

use Nyholm\Psr7\Request;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Tests\Payourself2\Bundle\MonobankBundle\Mocks\Adapter;

class SenderTest extends TestCase
{
    public function testNoUrl(): void
    {
        $expectedUrl = 'http://url';
        $expectedPath = '/adds';
        $expected = $expectedUrl . $expectedPath;

        $adapter = new Adapter(null, function (RequestInterface $request) use ($expected) {
            self::assertSame($expected, (string)$request->getUri());
        });

        $sender = new Sender($adapter, $expectedUrl);
        $request = new Request(RequestMethod::GET, $expectedPath);
        $sender->send($request);
    }

    public function testWithUrl(): void
    {
        $expectedUrl = 'http://url';
        $expectedPath = '/adds';
        $expected = $expectedUrl . $expectedPath;

        $adapter = new Adapter(null, function (RequestInterface $request) use ($expected) {
            self::assertSame($expected, (string)$request->getUri());
        });

        $sender = new Sender($adapter, 'http://url2');
        $request = new Request(RequestMethod::GET, $expected);
        $sender->send($request);
    }
}
