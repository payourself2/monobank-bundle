<?php

declare(strict_types=1);

namespace Payourself2\Bundle\MonobankBundle\Controller;

use Payourself2\Bundle\MonobankBundle\Client\PersonalClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonalController
{
    private PersonalClient $personalClient;

    public function __construct(PersonalClient $personalClient)
    {
        $this->personalClient = $personalClient;
    }

    public function index(): Response
    {
        $result = $this->personalClient->currency();

        return new Response(
            '<html><body>' . print_r(iterator_to_array($result)) . '</body></html>'
        );
    }

    public function clientInfo(Request $request): Response
    {
        $result = $this->personalClient->clientInfo();

        return new Response(
            '<html><body> ' . $result . '</body></html>'
        );
    }

    public function clientStatement(Request $request): Response
    {
        $result = $this->personalClient->clientStatement(
            $request->get('account_id'),
            time() - (7 * 24 * 60 * 60),
            //            time() - (5 * 24 * 60 * 60)
            null
        );

        return new Response(
            '<html><body> ' . $result . '</body></html>'
        );
    }

    public function webHook(Request $request): Response
    {
        $result = $this->personalClient->setWebHook(
            $request->get('web_hook_url', 'https://127.0.0.1'),
        );

        return new Response(
            '<html><body> ' . $result . '</body></html>'
        );
    }
}
