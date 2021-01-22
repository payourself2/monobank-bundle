<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Tests\Client\Action;

use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Exception;
use Payourself2\Bundle\MonobankBundle\Exception\TooManyRequestsException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class StatusCodeCheckerTest extends TestCase
{
    public function throwExceptionsProvider(): \Generator
    {
        yield 429 => [429, TooManyRequestsException::class];
    }

    /**
     * @dataProvider throwExceptionsProvider
     *
     * @param int $code
     * @param class-string<\Throwable> $exceptionClass
     *
     * @throws Exception\TooManyRequestsException
     * @throws Exception\BadRequestException
     * @throws Exception\ForbiddenException
     * @throws Exception\NotFoundException
     * @throws Exception\UnknownException
     */
    public function testThrowExceptions(int $code, string $exceptionClass):void
    {
        $this->expectException($exceptionClass);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn($code);

        $statusCodeChecker = new StatusCodeChecker();
        $statusCodeChecker->check($response);
    }
}
