<?php

declare(strict_types=1);

namespace Client\Action;

use Generator;
use Payourself2\Bundle\MonobankBundle\Action\StatusCodeChecker;
use Payourself2\Bundle\MonobankBundle\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class StatusCodeCheckerTest extends TestCase
{
    public function throwExceptionsProvider(): Generator
    {
        yield 429 => [429, Exception\TooManyRequestsException::class];
        yield 400 => [400, Exception\BadRequestException::class];
        yield 403 => [403, Exception\ForbiddenException::class];
        yield 404 => [404, Exception\NotFoundException::class];
        yield 429 => [429, Exception\TooManyRequestsException::class];
        yield 100 => [100, Exception\UnknownException::class];
    }

    /**
     * @dataProvider throwExceptionsProvider
     *
     * @param int $code
     * @param class-string<Throwable> $exceptionClass
     *
     * @throws Exception\TooManyRequestsException
     * @throws Exception\BadRequestException
     * @throws Exception\ForbiddenException
     * @throws Exception\NotFoundException
     * @throws Exception\UnknownException
     */
    public function testThrowExceptions(int $code, string $exceptionClass): void
    {
        $this->expectException($exceptionClass);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn($code);
        $response->method('getReasonPhrase')->willReturn('');

        $statusCodeChecker = new StatusCodeChecker();
        $statusCodeChecker->check($response);
    }
}
