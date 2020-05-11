<?php declare(strict_types = 1);

namespace OptiosAuthenticator\Provider;

use OptiosAuthenticator\Token;

class MemoryProvider implements ProviderInterface
{
    /**
     * @var array
     */
    private $tokens;

    /**
     * MemoryProvider constructor.
     *
     * @param Token[] $tokens
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @param string $bearerToken
     *
     * @return Token|null
     */
    public function getToken(string $bearerToken): ?Token
    {
        foreach ($this->tokens as $token) {
            if ($token->getBearerToken() === $bearerToken) {
                return $token;
            }
        }

        return null;
    }
}
