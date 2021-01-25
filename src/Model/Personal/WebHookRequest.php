<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Personal;

use Nyholm\Psr7\MessageTrait;
use Nyholm\Psr7\RequestTrait;
use Nyholm\Psr7\Stream;
use Nyholm\Psr7\Uri;
use Payourself2\Bundle\MonobankBundle\Config\Headers;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Psr\Http\Message\RequestInterface;

class WebHookRequest implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    private const PATH = '/personal/webhook';

    public function __construct(string $token, string $webHookUrl)
    {
        $this->method = RequestMethod::POST;
        $this->uri = new Uri(self::PATH);
        $headers = [
            Headers::TOKEN => $token,
        ];
        $this->setHeaders($headers);
        $body = '{"webHookUrl": "' . $webHookUrl . '"}';
        $this->withBody(Stream::create($body));
    }
}
