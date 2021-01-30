<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Adapter;

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NullAdapter implements SendRequestAdapterInterface
{
    public function send(RequestInterface $request): ResponseInterface
    {
        return new Response(200, [], '{}');
    }
}
