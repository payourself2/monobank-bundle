<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use Payourself2\Bundle\MonobankBundle\Exception;
use Psr\Http\Message\ResponseInterface;

class StatusCodeChecker
{
    public function check(ResponseInterface $response): void
    {
        switch ($response->getStatusCode()) {
            case 400:
                throw new Exception\BadRequestException();

            case 403:
                throw new Exception\ForbiddenException();

            case 404:
                throw new Exception\NotFoundException();

            case 429:
                throw new Exception\TooManyRequestsException();

            case 200:
                return;

            default:
                throw new Exception\UnknownException($response->getReasonPhrase());
        }
    }
}
