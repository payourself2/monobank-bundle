<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Handler;

use JMS\Serializer\SerializerInterface;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;

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

    public function handle($request, ?string $type)
    {
        $response = $this->sender->send($request);

        $this->statusCodeChecker->check($response);

        return $type === null ? null : $this->serializer->deserialize($response->getBody()->getContents(), $type,
            'json');
    }
}
