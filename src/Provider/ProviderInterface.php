<?php declare(strict_types=1);

namespace OptiosAuthenticator\Provider;

use OptiosAuthenticator\Token;

interface ProviderInterface
{
    public function getToken(string $bearerToken): ?Token;
}
