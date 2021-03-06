<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Handler\RequestHandler;
use Payourself2\Bundle\MonobankBundle\Model\Request\Personal\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Personal\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Personal\WebHookRequest;
use Payourself2\Bundle\MonobankBundle\Model\Response\ClientInfo;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;
use Payourself2\Bundle\MonobankBundle\Model\Response\Statement;

class PersonalClient
{
    private RequestHandler $requestHandler;

    private GeneralClient $generalClient;

    private string $monobankApiPersonalKey;

    public function __construct(
        RequestHandler $requestHandler,
        GeneralClient $generalClient,
        string $monobankApiPersonalKey
    ) {
        $this->requestHandler = $requestHandler;
        $this->generalClient = $generalClient;
        $this->monobankApiPersonalKey = $monobankApiPersonalKey;
    }

    /**
     * @return CurrencyInfo[]
     */
    public function currency(): array
    {
        return $this->generalClient->currency();
    }

    public function clientInfo(): ClientInfo
    {
        $request = new ClientInfoRequest($this->monobankApiPersonalKey);

        return $this->requestHandler->handle($request,ClientInfo::class);
    }

    /**
     * @param string $accountId
     * @param int $from
     * @param int|null $to
     * @return Statement[]
     */
    public function clientStatement(
        string $accountId,
        int $from,
        ?int $to
    ): array {
        $request = new ClientStatementRequest(
            $this->monobankApiPersonalKey,
            $accountId,
            $from,
            $to
        );

        return $this->requestHandler->handle($request,'<array'.Statement::class.'>');
    }

    public function setWebHook(string $webHookUrl): bool
    {
        $request = new WebHookRequest(
            $this->monobankApiPersonalKey,
            $webHookUrl
        );

        $this->requestHandler->handle($request,null);

        return true;
    }
}
