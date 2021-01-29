<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Generator;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\AuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\CheckAuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Corporate\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\General\CurrencyInfo;

class CorporateClient
{
    private Sender $sender;

    private SendRequestAdapterInterface $adapter;

    private Signer $signer;

    private GeneralClient $generalClient;

    public function __construct(
        Sender $sender,
        Signer $signer,
        GeneralClient $generalClient
    ) {
        $this->sender = $sender;
        $this->signer = $signer;
        $this->generalClient = $generalClient;
    }

    /**
     * @return Generator<int, CurrencyInfo>
     */
    public function currency(): Generator
    {
        return $this->generalClient->currency();
    }

    public function auth(string $permission, string $callbackUrl)
    {
        $request = new AuthRequest($this->signer, $permission, $callbackUrl);

        return $this->sender->send($request);
    }

    public function checkAuth(string $requestId)
    {
        $request = new CheckAuthRequest($this->signer, $requestId);

        return $this->sender->send($request);
    }

    public function clientInfo(string $requestId)
    {
        $request = new ClientInfoRequest($this->signer, $requestId);

        return $this->sender->send($request);
    }

    public function clientStatement(
        string $requestId,
        string $accountId,
        int $from,
        ?int $to
    ) {
        $request = new ClientStatementRequest(
            $this->signer,
            $requestId,
            $accountId,
            $from,
            $to
        );

        return $this->sender->send($request);
    }
}
