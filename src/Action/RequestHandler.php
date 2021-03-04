<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use JMS\Serializer\SerializerInterface;

class RequestHandler
{
    private Sender $sender;

    private SerializerInterface $jmsSerializer;

    public function __construct(Sender $sender, SerializerInterface $jmsSerializer)
    {
        $this->sender = $sender;
        $this->jmsSerializer = $jmsSerializer;
    }

    public function handle($request, ?string $type)
    {
        $response = $this->sender->send($request);
        return $type === null?null:$this->jmsSerializer->deserialize($response->getBody()->getContents(), $type, 'json') ;
    }
}
