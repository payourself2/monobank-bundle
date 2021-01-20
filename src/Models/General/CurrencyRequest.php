<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Models\General;

use Payourself2\Bundle\MonobankBundle\Config\RequestMethod;
use Nyholm\Psr7\MessageTrait;
use Nyholm\Psr7\RequestTrait;
use Nyholm\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

class CurrencyRequest implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    private const PATH = '/bank/currency';

    public function __construct(string $basePath)
    {
        $this->method = RequestMethod::GET;
        $this->uri = new Uri(sprintf('%s%s', $basePath, self::PATH));
    }
}