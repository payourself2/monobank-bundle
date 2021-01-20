<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Model\Personal\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Personal\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\Personal\WebHookRequest;

class PersonalClient
{
    private SendRequestAdapterInterface $adapter;

    private Signer $signer;

    private string $monobankApiBasePath;

    private string $monobankApiPersonalKey;

    private GeneralClient $generalClient;

    public function __construct(
        SendRequestAdapterInterface $adapter,
        Signer $signer,
        string $monobankApiBasePath,
        string $monobankApiPersonalKey,
        GeneralClient $generalClient
    ) {
        $this->adapter = $adapter;
        $this->signer = $signer;
        $this->monobankApiBasePath = $monobankApiBasePath;
        $this->monobankApiPersonalKey = $monobankApiPersonalKey;
        $this->generalClient = $generalClient;
    }

    public function currency()
    {
        return $this->generalClient->currency();
    }

    public function clientInfo()
    {
        $request = new ClientInfoRequest($this->monobankApiBasePath, $this->monobankApiPersonalKey);

        return $this->adapter->send($request);
    }

    public function clientStatement(
        string $accountId,
        int $from,
        ?int $to
    ) {
        $request = new ClientStatementRequest(
            $this->monobankApiBasePath,
            $this->monobankApiPersonalKey,
            $accountId,
            $from,
            $to
        );

        return $this->adapter->send($request);
    }

    public function setWebHook(string $webHookUrl)
    {
        $request = new WebHookRequest(
            $this->monobankApiBasePath,
            $this->monobankApiPersonalKey,
            $webHookUrl
        );

        return $this->adapter->send($request);
    }
}
