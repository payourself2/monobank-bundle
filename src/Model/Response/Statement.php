<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @psalm-allow-private-mutation
 */
class Statement
{
    /**
     * @Serializer\Type("string")
     */
    public string $id;

    /**
     * @Serializer\Type("int")
     * @Serializer\Accessor(setter="setDate")
     */
    public \DateTimeImmutable $date;

    /**
     * @Serializer\Type("string")
     */
    public string $description;

    /**
     * @Serializer\Type("int")
     */
    public int $mcc;

    /**
     * @Serializer\Type("bool")
     */
    public bool $hold;

    /**
     * @Serializer\Type("int")
     */
    public int $amount;

    /**
     * @Serializer\Type("int")
     */
    public int $operationAmount;

    /**
     * @Serializer\Type("int")
     */
    public int $currencyCode;

    /**
     * @Serializer\Type("int")
     */
    public int $commissionRate;

    /**
     * @Serializer\Type("int")
     */
    public int $cashbackAmount;

    /**
     * @Serializer\Type("int")
     */
    public int $balance;

    /**
     * @Serializer\Type("string")
     */
    public string $comment;

    /**
     * @Serializer\Type("string")
     */
    public string $receiptId;

    /**
     * @Serializer\Type("string")
     */
    public string $counterEdrpou;

    /**
     * @Serializer\Type("string")
     */
    public string $counterIban;

    public function setDate(int $timestamp): void
    {
        $this->date = new \DateTimeImmutable("@{$timestamp}");
    }
}
