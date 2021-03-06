<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use Nyholm\Psr7\Uri;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Sender
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

    public function send(RequestInterface $request): ResponseInterface
    {
        $url = $request->getUri();
        if ($url->getHost() === '') {
            $url = sprintf('%s%s', $this->monobankApiBasePath, (string)$url);
            $request = $request->withUri(new Uri($url));
        }

        return $this->adapter->send($request);
    }
}
