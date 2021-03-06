<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Exception\UnauthorizedException;
use Payourself2\Bundle\MonobankBundle\Handler\RequestHandler;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\AuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\CheckAuthRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Corporate\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;

class CorporateClient
{
    private RequestHandler $requestHandler;

    private Signer $signer;

    private GeneralClient $generalClient;

    public function __construct(
        RequestHandler $requestHandler,
        Signer $signer,
        GeneralClient $generalClient
    ) {
        $this->requestHandler = $requestHandler;
        $this->signer = $signer;
        $this->generalClient = $generalClient;
    }

    /**
     * @return CurrencyInfo[]
     */
    public function currency(): array
    {
        return $this->generalClient->currency();
    }

    public function auth(string $permission, string $callbackUrl)
    {
        $request = new AuthRequest($this->signer, $permission, $callbackUrl);

        return $this->requestHandler->handle($request, '');
    }

    public function checkAuth(string $requestId): bool
    {
        try {
            $request = new CheckAuthRequest($this->signer, $requestId);

            $this->requestHandler->handle($request, null);

            return true;
        } catch (UnauthorizedException $e) {
            return false;
        }
    }

    public function clientInfo(string $requestId)
    {
        $request = new ClientInfoRequest($this->signer, $requestId);

        return $this->requestHandler->handle($request, '');
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

        return $this->requestHandler->handle($request, '');
    }
}
