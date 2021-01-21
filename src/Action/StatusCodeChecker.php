<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use Payourself2\Bundle\MonobankBundle\Exception;

class StatusCodeChecker
{
    public static function check(int $code): void
    {
        switch($code){
            case 400:
                throw new Exception\BadRequestException();
                break;
            case 403:
                throw new Exception\ForbiddenException();
                break;
            case 404:
                throw new Exception\NotFoundException();
                break;
            case 429:
                throw new Exception\TooManyRequestsException();
                break;
        }
    }
}
