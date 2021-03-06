<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @psalm-allow-private-mutation
 */
class ClientAccount
{
    /**
     * @Serializer\Type("string")
     */
    public string $id;

    /**
     * @Serializer\Type("int")
     */
    public int $balance;

    /**
     * @Serializer\Type("int")
     */
    public int $creditLimit;

    /**
     * @Serializer\Type("string")
     */
    public string $type;

    /**
     * @Serializer\Type("int")
     */
    public int $currencyCode;

    /**
     * @Serializer\Type("string")
     */
    public string $cashbackType;
}
