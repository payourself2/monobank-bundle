<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @psalm-allow-private-mutation
 */
class ClientInfo
{
    /**
     * @Serializer\Type("string")
     */
    public string $id;

    /**
     * @Serializer\Type("string")
     */
    public string $name;

    /**
     * @Serializer\Type("string")
     */
    public string $webHookUrl;

    /**
     * @var ClientAccount[]
     * @Serializer\Type("array<Payourself2\Bundle\MonobankBundle\Model\Response\ClientAccount>")
     */
    public array $accounts;
}
