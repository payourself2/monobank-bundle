<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\AuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\CheckAuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\CurrencyRequest;

class CorporateClient
{
    private SendRequestAdapterInterface $adapter;

    private Signer $signer;

    private string $monobankApiBasePath;

    private GeneralClient $generalClient;

    public function __construct(
        SendRequestAdapterInterface $adapter,
        Signer $signer,
        string $monobankApiBasePath,
        GeneralClient $generalClient
    ) {
        $this->adapter = $adapter;
        $this->signer = $signer;
        $this->monobankApiBasePath = $monobankApiBasePath;
        $this->generalClient = $generalClient;
    }

    public function currency()
    {
        return $this->generalClient->currency();
    }

    public function auth(string $permission, string $callbackUrl)
    {
        $request = new AuthRequest($this->signer, $this->monobankApiBasePath, $permission, $callbackUrl);

        return $this->adapter->send($request);
    }

    public function checkAuth(string $requestId)
    {
        $request = new CheckAuthRequest($this->signer, $this->monobankApiBasePath, $requestId);

        return $this->adapter->send($request);
    }

    public function clientInfo(string $requestId)
    {
        $request = new ClientInfoRequest($this->signer, $this->monobankApiBasePath, $requestId);

        return $this->adapter->send($request);
    }

    public function clientStatement(
        string $requestId,
        string $accountId,
        int $from,
        ?int $to
    ) {
        $request = new ClientStatementRequest(
            $this->signer,
            $this->monobankApiBasePath,
            $requestId,
            $accountId,
            $from,
            $to
        );

        return $this->adapter->send($request);
    }
}
