<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use JMS\Serializer\SerializerInterface;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Model\Request\General\CurrencyRequest;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;

class GeneralClient
{
    private Sender $sender;

    private SerializerInterface $jmsSerializer;

    public function __construct(Sender $sender, SerializerInterface $jmsSerializer)
    {
        $this->sender = $sender;
        $this->jmsSerializer = $jmsSerializer;
    }

    public function currency()
    {
        $request = new CurrencyRequest();

        $response = $this->sender->send($request);
        $result =  $this->jmsSerializer->deserialize($response->getBody()->getContents(), 'array<'.CurrencyInfo::class.'>', 'json');

        return $result;
    }
}
