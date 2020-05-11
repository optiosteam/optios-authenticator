<?php declare(strict_types = 1);

namespace Tests\OptiosAuthenticator;

use OptiosAuthenticator\Token;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TokenTest extends TestCase
{
    /**
     * @test
     */
    public function itCanConstruct()
    {
        $uuid             = Uuid::uuid4();
        $organisationUuid = Uuid::uuid4();
        $expiresAt        = new \DateTime('+1 hour');

        $token = new Token($uuid->toString(), $expiresAt, $organisationUuid->toString());

        $this->assertFalse($token->isExpired());
        $this->assertEquals($token->getBearerToken(), $uuid->toString());
        $this->assertEquals($token->getOrganisationUuid(), $organisationUuid->toString());
    }
}
