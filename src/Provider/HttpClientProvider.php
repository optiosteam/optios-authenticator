<?php declare(strict_types = 1);

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
     * MemoryProvider constructor.
     *
     * @param string $authenticationUrl
     */
    public function __construct(string $authenticationUrl)
    {
        $this->authenticationUrl = $authenticationUrl;
    }

    /**
     * @param string $bearerToken
     *
     * @return Token|null
     */
    public function getToken(string $bearerToken): ?Token
    {
        $client   = HttpClient::create();
        $response = $client->request(
            'POST',
            $this->authenticationUrl,
            ['json' => ['access_token' => $bearerToken]]
        );

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        return Token::create($response->toArray());
    }
}
