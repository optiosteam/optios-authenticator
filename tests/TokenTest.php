<?php
declare(strict_types=1);

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
        $uuid = Uuid::uuid4();
        $organisationUuid = Uuid::uuid4();
        $expiresAt = new \DateTime('+1 hour');

        $token = new Token(
            $uuid->toString(),
            $expiresAt,
            $organisationUuid->toString(),
            $organisationUuid->toString(),
            1,
            'nl'
        );

        $this->assertFalse($token->isExpired());
        $this->assertEquals($uuid->toString(), $token->getBearerToken());
        $this->assertEquals($organisationUuid->toString(), $token->getOrganisationUuid());
        $this->assertEquals($organisationUuid->toString(), $token->getEstablishmentUuid());
        $this->assertEquals(1, $token->getEstablishmentId());
    }
}
