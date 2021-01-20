<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Controller;

use Payourself2\Bundle\MonobankBundle\Action\Signer;
use Payourself2\Bundle\MonobankBundle\Adapter\SymfonyClientAdapter;
use Payourself2\Bundle\MonobankBundle\Client\CorporateClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CorporateController
{
    private CorporateClient $corporateClient;

    public function __construct(CorporateClient $corporateClient)
    {
        $this->corporateClient = $corporateClient;
    }

    public function index(): Response
    {
        $result = $this->corporateClient->currency();

        return new Response(
            '<html><body>' . print_r($result) . '</body></html>'
        );
    }

    public function auth(): Response
    {
        $result = $this->corporateClient->auth('sp','http://localhost:8080');

        return new Response(
            '<html><body>' . print_r($result) . '</body></html>'
        );
    }

    public function checkAuth(Request $request): Response
    {
        $result = $this->corporateClient->checkAuth($request->get('request_id'));

        return new Response(
            '<html><body> ' . $result . '</body></html>'
        );
    }

    public function clientInfo(Request $request): Response
    {
        $result = $this->corporateClient->clientInfo($request->get('request_id'));

        return new Response(
            '<html><body> ' . $result . '</body></html>'
        );
    }

    public function clientStatement(Request $request): Response
    {
        $result = $this->corporateClient->clientStatement(
            $request->get('request_id'),
            $request->get('account_id'),
            time() - (7 * 24 * 60 * 60),
//            time() - (5 * 24 * 60 * 60)
            null
        );

        return new Response(
            '<html><body> ' . $result . '</body></html>'
        );
    }
}
