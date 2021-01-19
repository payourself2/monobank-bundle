<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Models\Corporate;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Nyholm\Psr7\MessageTrait;
use Nyholm\Psr7\RequestTrait;
use Nyholm\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

class ClientStatementRequest implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    private const PATH = '/personal/statement/{accountId}/{from}';
    private const ADDITIONAL_PATH = '/{to}';

    public function __construct(
        Signer $signer,
        string $basePath,
        string $requestId,
        string $accountId,
        int $from,
        ?int $to
    )
    {
        $this->method = RequestMethod::GET;
        $url = \sprintf('%s%s', $basePath, self::PATH);
        $url = \str_replace(['{accountId}','{from}'], [$accountId,$from], $url);
        $url .= $to === null? '' : "/{$to}";

        $this->uri = new Uri($url);

        $time = time();
        $headers = [
            'X-Key-Id' => $signer->getPublicKey(),
            'X-Time' => $time,
            'X-Request-Id' => $requestId,
            'X-Sign' => $signer->sign((string)$time, $requestId, $this->uri->getPath()),
        ];
        $this->setHeaders($headers);
    }
}
