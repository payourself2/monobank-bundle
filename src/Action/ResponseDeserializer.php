<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

use Psr\Http\Message\ResponseInterface;

class ResponseDeserializer
{
    public function deserialise(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();
        if (empty($body)) {
            return [];
        }

        return json_decode($body, true);
    }
}
