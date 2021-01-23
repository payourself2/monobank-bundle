<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Adapter;

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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

        $response = $this->client->request(
            $request->getMethod(),
            (string)$request->getUri(),
            $options
        );

        return new Response(
            $response->getStatusCode(),
            $response->getHeaders(false),
            $response->toStream(false)
        );
    }
}
