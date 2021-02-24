<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use Nyholm\Psr7\Uri;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use \Payourself2\Bundle\MonobankBundle\Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Sender
{
    private SendRequestAdapterInterface $adapter;

    private StatusCodeChecker $statusCodeChecker;

    private string $monobankApiBasePath;

    public function __construct(
        SendRequestAdapterInterface $adapter,
        StatusCodeChecker $statusCodeChecker,
        string $monobankApiBasePath
    ) {
        $this->adapter = $adapter;
        $this->statusCodeChecker = $statusCodeChecker;
        $this->monobankApiBasePath = $monobankApiBasePath;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     *
     * @throws Exception\BadRequestException
     * @throws Exception\ForbiddenException
     * @throws Exception\NotFoundException
     * @throws Exception\TooManyRequestsException
     * @throws Exception\UnauthorizedException
     * @throws Exception\UnknownException
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        $url = $request->getUri();
        if ($url->getHost() === '') {
            $url = sprintf('%s%s', $this->monobankApiBasePath, (string)$url);
            $request = $request->withUri(new Uri($url));
        }

        $response = $this->adapter->send($request);
        $this->statusCodeChecker->check($response);

        return $response;
    }
}
