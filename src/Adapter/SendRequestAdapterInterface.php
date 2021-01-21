<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Adapter;

use Psr\Http\Message\RequestInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface SendRequestAdapterInterface
{
    public function send(RequestInterface $request): ResponseInterface;
}
