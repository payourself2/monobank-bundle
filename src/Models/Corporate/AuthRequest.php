<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Models\Corporate;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Nyholm\Psr7\MessageTrait;
use Nyholm\Psr7\RequestTrait;
use Nyholm\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

class AuthRequest implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    private const PATH = '/personal/auth/request';

    public function __construct(Signer $signer, string $basePath, string $permission, string $callbackUrl)
    {
        $this->method = RequestMethod::POST;
        $this->uri = new Uri(sprintf('%s%s', $basePath, self::PATH));
        $time = time();
        $headers = [
            'X-Key-Id' => $signer->getPublicKey(),
            'X-Time' => $time,
            'X-Permissions' => $permission,
            'X-Sign' => $signer->sign((string)$time, $permission, self::PATH),
            'X-Callback' => $callbackUrl,
        ];
        $this->setHeaders($headers);
    }
}
