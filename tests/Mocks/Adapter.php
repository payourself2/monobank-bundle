<?php

declare(strict_types=1);

namespace Tests\Payourself2\Bundle\MonobankBundle\Mocks;

use Closure;
use Nyholm\Psr7\Response;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Adapter implements SendRequestAdapterInterface
{
    private ?string $path;

    /** @var callable|null */
    private $validateRequestCallback;

    /** @var resource|null */
    private $resource;

    public function __construct(string $path = null, ?callable $validateRequestCallback = null)
    {
        $this->path = $path;
        $this->validateRequestCallback = $validateRequestCallback;
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        $this->resource = $this->path === null ? null : fopen($this->path, 'rb');

        if ($this->validateRequestCallback !== null) {
            Closure::fromCallable($this->validateRequestCallback)($request);
        }

        return new Response(200, [], $this->resource);
    }

    protected function tearDown(): void
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }
}
