<?php

declare(strict_types=1);

namespace Client\General;

use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Client\GeneralClient;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyInfo;
use PHPUnit\Framework\TestCase;

class GeneralClientTest extends TestCase
{
    public function testConvertingResult(): void
    {
        $data = include(__DIR__ . '/../../Fixtures/currencyArray.php');
        $sender = $this->createMock(Sender::class);
        $sender->method('send')->willReturn($data);

        $client = new GeneralClient($sender);
        $result = iterator_to_array($client->currency());

        self::assertCount(3, $result);
        self::assertContainsOnlyInstancesOf(CurrencyInfo::class, $result);
    }
}

