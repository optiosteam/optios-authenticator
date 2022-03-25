<?php

declare(strict_types=1);

namespace OptiosAuthenticator\Provider;

use OptiosAuthenticator\Token;
use Symfony\Component\HttpClient\HttpClient;

class HttpClientProvider implements ProviderInterface
{
    /**
     * @var string
     */
    private $authenticationUrl;

    /**
     * @var string|null
     */
    private $proxy;

    /**
     * MemoryProvider constructor.
     *
     * @param string $authenticationUrl
     * @param string|null $proxy
     */
    public function __construct(string $authenticationUrl, ?string $proxy = null)
    {
        $this->authenticationUrl = $authenticationUrl;
        $this->proxy             = $proxy;
    }

    /**
     * @param string $bearerToken
     *
     * @return Token|null
     */
    public function getToken(string $bearerToken): ?Token
    {
        $client = HttpClient::create();

        $options = ['json' => ['access_token' => $bearerToken]];
        if (!empty($this->proxy)) {
            $options['verify_host'] = false;
            $options['verify_peer'] = false;
            $options['proxy']       = $this->proxy;
        }

        $response = $client->request(
            'POST',
            $this->authenticationUrl,
            $options
        );


        if ($response->getStatusCode() !== 200) {
            return null;
        }

        return Token::create($response->toArray());
    }
}
