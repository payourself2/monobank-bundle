<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Adapter;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface SendRequestAdapterInterface
{
    public function send(RequestInterface $request);//: ResponseInterface;
}
