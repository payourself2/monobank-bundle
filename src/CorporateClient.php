<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Models\Corporate\AuthRequest;
use Payourself2\Bundle\MonobankBundle\Models\Corporate\CheckAuthRequest;
use Payourself2\Bundle\MonobankBundle\Models\Corporate\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Models\Corporate\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Models\Corporate\CurrencyRequest;

class CorporateClient
{
    private SendRequestAdapterInterface $adapter;

    private Signer $signer;

    private string $monobankApiBasePath;
    private     PublicClient $publicClient;

    public function __construct(
        SendRequestAdapterInterface $adapter,
        Signer $signer,
        string $monobankApiBasePath,
        PublicClient $publicClient
    ) {
        $this->adapter = $adapter;
        $this->signer = $signer;
        $this->monobankApiBasePath = $monobankApiBasePath;
        $this->publicClient = $publicClient;
    }

    public function currency()
    {
        return $this->publicClient->currency();
    }

    public function auth(string $permission = 'sp', string $callbackUrl = 'http://localhost:8080')
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
