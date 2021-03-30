<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Handler;

use JMS\Serializer\SerializerInterface;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Exception;
use Psr\Http\Message\RequestInterface;

class RequestHandler
{
    private Sender $sender;

    private StatusCodeChecker $statusCodeChecker;

    private SerializerInterface $serializer;

    public function __construct(
        Sender $sender,
        StatusCodeChecker $statusCodeChecker,
        SerializerInterface $jmsSerializer
    ) {
        $this->sender = $sender;
        $this->statusCodeChecker = $statusCodeChecker;
        $this->serializer = $jmsSerializer;
    }

    /**
     * @psalm-template T
     *
     * @param RequestInterface $request
     * @psalm class-string<T>|string|null $type
     * @psalm-return T
     *
     * @throws Exception\BadRequestException
     * @throws Exception\ForbiddenException
     * @throws Exception\NotFoundException
     * @throws Exception\TooManyRequestsException
     * @throws Exception\UnauthorizedException
     * @throws Exception\UnknownException
     */
    public function handle(RequestInterface $request, ?string $type)
    {
        $response = $this->sender->send($request);

        $this->statusCodeChecker->check($response);
        /** @phpstan-ignore-next-line */
        return $type === null ? null : $this->serializer->deserialize(
            $response->getBody()->getContents(),
            $type,
            'json'
        );
    }
}
