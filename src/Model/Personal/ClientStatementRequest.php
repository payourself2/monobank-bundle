<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Personal;

use Nyholm\Psr7\MessageTrait;
use Nyholm\Psr7\RequestTrait;
use Nyholm\Psr7\Uri;
use Payourself2\Bundle\MonobankBundle\Config\Headers;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Psr\Http\Message\RequestInterface;

use function sprintf;
use function str_replace;

class ClientStatementRequest implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    private const PATH = '/personal/statement/{accountId}/{from}';
    private const ADDITIONAL_PATH = '/{to}';

    public function __construct(
        string $basePath,
        string $token,
        string $accountId,
        int $from,
        ?int $to
    ) {
        $this->method = RequestMethod::GET;
        $url = sprintf('%s%s', $basePath, self::PATH);
        $url = str_replace(['{accountId}', '{from}'], [$accountId, $from], $url);
        $url .= $to === null ? '' : "/{$to}";
        $this->uri = new Uri($url);

        $headers = [
            Headers::TOKEN => $token,
        ];
        $this->setHeaders($headers);
    }
}
