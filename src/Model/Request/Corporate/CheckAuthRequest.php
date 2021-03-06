<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Model\Request\Corporate;

use Nyholm\Psr7\MessageTrait;
use Nyholm\Psr7\RequestTrait;
use Nyholm\Psr7\Uri;
use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Config\Headers;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Psr\Http\Message\RequestInterface;

class CheckAuthRequest implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    private const PATH = '/personal/auth/request';

    public function __construct(Signer $signer, string $requestId)
    {
        $this->method = RequestMethod::GET;
        $this->uri = new Uri(self::PATH);
        $time = time();
        $headers = [
            Headers::KEY => $signer->getPublicKey(),
            Headers::TIME => $time,
            Headers::REQUEST_ID => $requestId,
            Headers::SIGN => $signer->sign((string)$time, $requestId, self::PATH),
        ];
        $this->setHeaders($headers);
    }
}
