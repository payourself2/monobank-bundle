<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use Nyholm\Psr7\Uri;
use Payourself2\Bundle\MonobankBundle\Adapter\NullAdapter;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use \Payourself2\Bundle\MonobankBundle\Exception;
use Psr\Http\Message\RequestInterface;

class Sender
{
    private SendRequestAdapterInterface $adapter;

    private ResponseDeserializer $deserializer;

    private StatusCodeChecker $statusCodeChecker;

    private string $monobankApiBasePath;

    public function __construct(
        ResponseDeserializer $deserializer,
        StatusCodeChecker $statusCodeChecker,
        string $monobankApiBasePath,
        ?SendRequestAdapterInterface $adapter = null
    ) {
        $this->deserializer = $deserializer;
        $this->statusCodeChecker = $statusCodeChecker;
        $this->monobankApiBasePath = $monobankApiBasePath;
        $this->adapter = $adapter?? new NullAdapter();
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws \JsonException
     * @throws Exception\BadRequestException
     * @throws Exception\ForbiddenException
     * @throws Exception\NotFoundException
     * @throws Exception\TooManyRequestsException
     * @throws Exception\UnauthorizedException
     * @throws Exception\UnknownException
     */
    public function send(RequestInterface $request): array
    {
        $url = $request->getUri();
        if ($url->getHost() === '') {
            $url = sprintf('%s%s', $this->monobankApiBasePath, (string)$url);
            $request = $request->withUri(new Uri($url));
        }

        $response = $this->adapter->send($request);
        $this->statusCodeChecker->check($response);

        return $this->deserializer->deserialise($response);
    }
}
