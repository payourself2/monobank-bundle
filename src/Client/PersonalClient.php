<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Adapter\SendRequestAdapterInterface;
use Payourself2\Bundle\MonobankBundle\Model\Personal\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Personal\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\Personal\WebHookRequest;

class PersonalClient
{
    private Sender $sender;

    private Signer $signer;

    private string $monobankApiPersonalKey;

    private GeneralClient $generalClient;

    public function __construct(
        Sender $sender,
        Signer $signer,
        string $monobankApiPersonalKey,
        GeneralClient $generalClient
    ) {
        $this->sender = $sender;
        $this->signer = $signer;
        $this->monobankApiPersonalKey = $monobankApiPersonalKey;
        $this->generalClient = $generalClient;
    }

    public function currency()
    {
        return $this->generalClient->currency();
    }

    public function clientInfo()
    {
        $request = new ClientInfoRequest($this->monobankApiPersonalKey);

        return $this->sender->send($request);
    }

    public function clientStatement(
        string $accountId,
        int $from,
        ?int $to
    ) {
        $request = new ClientStatementRequest(
            $this->monobankApiPersonalKey,
            $accountId,
            $from,
            $to
        );

        return $this->sender->send($request);
    }

    public function setWebHook(string $webHookUrl)
    {
        $request = new WebHookRequest(
            $this->monobankApiPersonalKey,
            $webHookUrl
        );

        return $this->sender->send($request);
    }
}
