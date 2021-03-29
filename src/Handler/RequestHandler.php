<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Handler;

use JMS\Serializer\SerializerInterface;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Exception;
use Payourself2\Bundle\MonobankBundle\Model\Response\ClientAccount;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;
use Payourself2\Bundle\MonobankBundle\Model\Response\Statement;
use Payourself2\Bundle\MonobankBundle\Model\Response\Token;
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
     * @param RequestInterface $request
     * @psalm-param class-string<Token>|class-string<Statement>|class-string<CurrencyInfo>|class-string<ClientAccount>|null $type
     * @return mixed|Token|Statement|array<int,CurrencyInfo>|ClientAccount|null
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

        return $type === null ? null : $this->serializer->deserialize(
            $response->getBody()->getContents(),
            $type,
            'json'
        );
    }
}
