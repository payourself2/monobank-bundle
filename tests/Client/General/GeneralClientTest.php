<?php

declare(strict_types=1);

namespace Tests\Payourself2\Bundle\MonobankBundle\Client\General;

use Payourself2\Bundle\MonobankBundle\Client\GeneralClient;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;
use PHPUnit\Framework\TestCase;
use Tests\Payourself2\Bundle\MonobankBundle\Mocks\Adapter;
use Tests\Payourself2\Bundle\MonobankBundle\Mocks\RequestHandlerMock;

/**
 * @group IntegrationTest
 */
class GeneralClientTest extends TestCase
{
    public function testNoData(): void
    {
        $requestHandler = (new RequestHandlerMock())->createMock();
        $generalClient = new GeneralClient($requestHandler);
        $result = $generalClient->currency();

        self::assertEmpty($result);
    }

    public function testHasData(): void
    {
        $adapter = new Adapter(PAYOURSELF2_FIXTURES_PATH.'/currency.json');
        $requestHandler = (new RequestHandlerMock($adapter))->createMock();
        $generalClient = new GeneralClient($requestHandler);
        $result = $generalClient->currency();

        self::assertContainsOnlyInstancesOf(CurrencyInfo::class, $result);
    }
}

