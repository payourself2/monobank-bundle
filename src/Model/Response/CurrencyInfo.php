<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @psalm-allow-private-mutation
 */
class CurrencyInfo
{
    /**
     * @Serializer\Type("int")
     */
    public int $currencyCodeA;

    /**
     * @Serializer\Type("int")
     */
    public int $currencyCodeB;

    /**
     * @Serializer\Type("int")
     * @Serializer\Accessor(setter="setDate")
     */
    public \DateTimeImmutable $date;

    /**
     * @Serializer\Type("float")
     */
    public ?float $rateSell;

    /**
     * @Serializer\Type("float")
     */
    public ?float $rateBuy;

    /**
     * @Serializer\Type("float")
     */
    public ?float $rateCross;

    public function setDate(int $timestamp): void
    {
        $this->date = new \DateTimeImmutable("@{$timestamp}");
    }
}
