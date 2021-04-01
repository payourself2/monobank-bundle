<?php

declare(strict_types=1);

namespace Tests\Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Client\CorporateClient;
use Payourself2\Bundle\MonobankBundle\Client\GeneralClient;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;
use PHPUnit\Framework\TestCase;
use Tests\Payourself2\Bundle\MonobankBundle\Mocks\Adapter;
use Tests\Payourself2\Bundle\MonobankBundle\Mocks\RequestHandlerMock;

class CorporateClientTest extends TestCase
{
    public function testNoCurrencyData(): void
    {
        $signer = new Signer('', '');
        $requestHandler = (new RequestHandlerMock())->createMock();
        $generalClient = new GeneralClient($requestHandler);

        $corporateClient = new CorporateClient(
            $requestHandler,
            $signer,
            $generalClient
        );
        $result = $corporateClient->currency();

        self::assertEmpty($result);
    }

    public function testHasCurrencyData(): void
    {
        $signer = new Signer('', '');
        $adapter = new Adapter(PAYOURSELF2_FIXTURES_PATH . '/currency.json');
        $requestHandler = (new RequestHandlerMock($adapter))->createMock();
        $generalClient = new GeneralClient($requestHandler);

        $corporateClient = new CorporateClient(
            $requestHandler,
            $signer,
            $generalClient
        );
        $result = $corporateClient->currency();

        self::assertCount(3, $result);
        self::assertContainsOnlyInstancesOf(CurrencyInfo::class, $result);
    }
}
