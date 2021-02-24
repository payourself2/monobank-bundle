<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Response;

use DateTime;

class Statement
{
    public string $id;

    public int $timestamp;
    public Datetime $date;

    public string $description;

    public int $mcc;

    public bool $hold;

    public int $amount;

    public int $operationAmount;

    public int $currencyCode;

    public int $commissionRate;

    public int $cashbackAmount;

    public int $balance;

    public string $comment;

    public string $receiptId;

    public string $counterEdrpou;

    public string $counterIban;

    /**
     * Statement constructor.
     * @param string $id
     * @param DateTime $date
     * @param string $description
     * @param int $mcc
     * @param bool $hold
     * @param int $amount
     * @param int $operationAmount
     * @param int $currencyCode
     * @param int $commissionRate
     * @param int $cashbackAmount
     * @param int $balance
     * @param string $comment
     * @param string $receiptId
     * @param string $counterEdrpou
     * @param string $counterIban
     */
    public function __construct(
        string $id,
        int $timestamp,
        string $description,
        int $mcc,
        bool $hold,
        int $amount,
        int $operationAmount,
        int $currencyCode,
        int $commissionRate,
        int $cashbackAmount,
        int $balance,
        string $comment,
        string $receiptId,
        string $counterEdrpou,
        string $counterIban
    ) {
        $this->id = $id;
        $this->date = new DateTime("@{$timestamp}");;
        $this->description = $description;
        $this->mcc = $mcc;
        $this->hold = $hold;
        $this->amount = $amount;
        $this->operationAmount = $operationAmount;
        $this->currencyCode = $currencyCode;
        $this->commissionRate = $commissionRate;
        $this->cashbackAmount = $cashbackAmount;
        $this->balance = $balance;
        $this->comment = $comment;
        $this->receiptId = $receiptId;
        $this->counterEdrpou = $counterEdrpou;
        $this->counterIban = $counterIban;
    }

    /**
     * @param array<string, mixed> $item
     * @return static
     */
    public static function create(array $item): self
    {
        return new static(
            $item['id'],
            (int)$item['time'],
            $item['description'],
            (int)$item['mcc'],
            $item['hold'],
            (int)$item['amount'],
            (int)$item['operationAmount'],
            (int)$item['currencyCode'],
            (int)$item['commissionRate'],
            (int)$item['cashbackAmount'],
            (int)$item['balance'],
            (string)$item['comment'],
            (string)$item['receiptId'],
            (string)$item['counterEdrpou'],
            (string)$item['counterIban'],
        );
    }
}
