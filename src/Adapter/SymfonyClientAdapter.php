<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Adapter;

use Psr\Http\Message\RequestInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

use function count;

class SymfonyClientAdapter implements SendRequestAdapterInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        $options = [];
        if (count($request->getHeaders()) > 0) {
            $options['headers'] = $request->getHeaders();
        }

        return $this->client->request(
            $request->getMethod(),
            (string)$request->getUri(),
            $options
        );
    }
}
