<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Generator;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Exception\UnauthorizedException;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\AuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\CheckAuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\General\CurrencyInfo;

class CorporateClient
{
    private Sender $sender;

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


    public function currency()
    {
        return $this->generalClient->currency();
    }

    public function auth(string $permission, string $callbackUrl)
    {
        $request = new AuthRequest($this->signer, $permission, $callbackUrl);

        return $this->sender->send($request);
    }

    public function checkAuth(string $requestId): bool
    {
        try {
            $request = new CheckAuthRequest($this->signer, $requestId);

            $this->sender->send($request);

            return true;
        } catch (UnauthorizedException $e) {
            return false;
        }
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
