<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Personal;

use Nyholm\Psr7\MessageTrait;
use Nyholm\Psr7\RequestTrait;
use Nyholm\Psr7\Uri;
use Payourself2\Bundle\MonobankBundle\Config\Headers;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Psr\Http\Message\RequestInterface;

class ClientInfoRequest implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    private const PATH = '/personal/client-info';

    public function __construct(string $basePath, string $token)
    {
        $this->method = RequestMethod::GET;
        $this->uri = new Uri(sprintf('%s%s', $basePath, self::PATH));

        $headers = [
            Headers::TOKEN => $token,
        ];
        $this->setHeaders($headers);
    }
}
