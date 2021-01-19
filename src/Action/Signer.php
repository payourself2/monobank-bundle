<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Action;

class Signer
{
    private string $publicKey;

    private string $privateKey;

    public function __construct()
    {
        /**  @TODO  change to params */
        $this->publicKey = 'cc0eaee64ea73737075939c1e193d999c839ab81';
        $this->privateKey = file_get_contents(__DIR__ . '/../../config/test_priv.key');
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function sign(string $time, string $param, string $url): string
    {

        $key = openssl_get_privatekey($this->privateKey, "");
        $str = $time.$param.$url;
        openssl_sign($str, $sig, $key, OPENSSL_ALGO_SHA256);
        openssl_free_key($key);
        return base64_encode($sig);


        $key = openssl_pkey_get_private($this->privateKey, "");

        $str = $time . $param . $url;
        openssl_sign($str, $sig, $key, OPENSSL_ALGO_SHA256);
        openssl_free_key($key);

        return base64_encode($sig);
    }
}
