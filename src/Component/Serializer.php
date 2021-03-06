<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Component;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer as JmsSerializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class Serializer implements SerializerInterface
{
    private JmsSerializer $jmsSerializer;

    public function __construct()
    {
        $this->jmsSerializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
            ->build();
    }

    public function serialize(
        $data,
        string $format,
        ?SerializationContext $context = null,
        ?string $type = null
    ): string {
        return $this->jmsSerializer->serialize($data, $format, $context = null, $type = null);
    }

    public function deserialize(string $data, string $type, string $format, ?DeserializationContext $context = null)
    {
        return $this->jmsSerializer->deserialize($data, $type, $format, $context);
    }
}
