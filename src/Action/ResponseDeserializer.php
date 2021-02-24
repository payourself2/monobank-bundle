<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use JsonException;
use Psr\Http\Message\ResponseInterface;

class ResponseDeserializer
{
    /**
     * @param ResponseInterface $response
     * @return array<array-key,mixed>
     * @throws JsonException
     */
    public function deserialize(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();
        if (empty($body)) {
            return [];
        }

        return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }

}
