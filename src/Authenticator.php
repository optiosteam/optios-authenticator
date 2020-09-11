<?php declare(strict_types = 1);

namespace OptiosAuthenticator;

use OptiosAuthenticator\Provider\ProviderInterface;

class Authenticator
{
    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * MemoryAuthenticator constructor.
     *
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param string $bearerToken
     *
     * @return Token
     */
    public function authenticate(string $bearerToken): Token
    {
        $token = $this->provider->getToken($bearerToken);
        if (null === $token) {
            throw new AuthenticationException(sprintf('Could not find token for bearer: %s', $bearerToken));
        }

        if ($token->isExpired()) {
            throw new AuthenticationException(sprintf('Token %s is expired.', $bearerToken));
        }

        return $token;
    }
}
