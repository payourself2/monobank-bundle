<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @psalm-allow-private-mutation
 */
class Token
{
    /**
     * @Serializer\Type("string")
     */
    public string $tokenRequestId;

    /**
     * @Serializer\Type("string")
     */
    public string $acceptUrl;
}
