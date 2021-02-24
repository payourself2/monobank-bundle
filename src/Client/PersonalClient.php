<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Client;

use Generator;
use Payourself2\Bundle\MonobankBundle\Action\ResponseDeserializer;
use Payourself2\Bundle\MonobankBundle\Action\Sender;
use Payourself2\Bundle\MonobankBundle\Model\Request\Personal\ClientInfoRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Personal\ClientStatementRequest;
use Payourself2\Bundle\MonobankBundle\Model\Request\Personal\WebHookRequest;
use Payourself2\Bundle\MonobankBundle\Model\Response\ClientInfo;
use Payourself2\Bundle\MonobankBundle\Model\Response\CurrencyInfo;
use Payourself2\Bundle\MonobankBundle\Model\Response\Statement;

class PersonalClient
{
    private Sender $sender;

    private GeneralClient $generalClient;

    private string $monobankApiPersonalKey;

    public function __construct(
        Sender $sender,
        GeneralClient $generalClient,
        string $monobankApiPersonalKey
    ) {
        $this->sender = $sender;
        $this->generalClient = $generalClient;
        $this->monobankApiPersonalKey = $monobankApiPersonalKey;
    }

    /**
     * @return Generator<int, CurrencyInfo>
     */
    public function currency(): Generator
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

        $this->sender->send($request);

        return true;
    }
}
