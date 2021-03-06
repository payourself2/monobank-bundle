<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Handler;

use JMS\Serializer\SerializerInterface;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
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
     * @param $request
     * @psalm-param class-string<Token>|class-string<Statement>|class-string<CurrencyInfo>|class-string<ClientAccount>|null $type
     * @return Token|Statement|CurrencyInfo|ClientAccount|null
     *
     * @throws \Payourself2\Bundle\MonobankBundle\Exception\BadRequestException
     * @throws \Payourself2\Bundle\MonobankBundle\Exception\ForbiddenException
     * @throws \Payourself2\Bundle\MonobankBundle\Exception\NotFoundException
     * @throws \Payourself2\Bundle\MonobankBundle\Exception\TooManyRequestsException
     * @throws \Payourself2\Bundle\MonobankBundle\Exception\UnauthorizedException
     * @throws \Payourself2\Bundle\MonobankBundle\Exception\UnknownException
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
