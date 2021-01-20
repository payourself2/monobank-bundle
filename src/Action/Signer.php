<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

class Signer
{
    private string $publicKey;

    private string $privateKey;

    public function __construct(string $monobankApiPublicKey, string $monobankApiPrivateKey)
    {
        $this->publicKey = $monobankApiPublicKey;
        $this->privateKey = $monobankApiPrivateKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function sign(string $time, string $param, string $url): string
    {
        $key = openssl_pkey_get_private($this->privateKey, "");

        $str = $time . $param . $url;
        openssl_sign($str, $sig, $key, OPENSSL_ALGO_SHA256);
        openssl_pkey_free($key);

        return base64_encode($sig);
    }
}
