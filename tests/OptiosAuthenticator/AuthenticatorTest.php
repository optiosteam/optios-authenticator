<?php

namespace OptiosAuthenticator;

use OptiosAuthenticator\Provider\MemoryProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AuthenticatorTest extends TestCase
{
    /**
     * @var string
     */
    private $bearerToken;

    /**
     * @var string
     */
    private $expiredBearerToken;

    /**
     * @var Authenticator
     */
    private $authenticator;

    protected function setUp(): void
    {
        $this->bearerToken        = Uuid::uuid4()->toString();
        $this->expiredBearerToken = Uuid::uuid4()->toString();

        $token = new Token(
            $this->bearerToken,
            new \DateTime('+1 hour'),
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
            1
        );

        $expiredToken = new Token(
            $this->expiredBearerToken,
            new \DateTime('-1 hour'),
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
            2
        );

        $this->authenticator = new Authenticator(new MemoryProvider([$token, $expiredToken]));

        parent::setUp();
    }

    /**
     * @test
     */
    public function itCanAuthenticate()
    {
        $token = $this->authenticator->authenticate($this->bearerToken);
        $this->assertNotNull($token);
        $this->assertEquals($token->getBearerToken(), $this->bearerToken);
    }

    /**
     * @test
     * @expectedException
     */
    public function itThrowsExceptionWhenTokenIsNotFound()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Could not find token for bearer: ' . $uuid);
        $this->authenticator->authenticate($uuid);
    }

    /**
     * @test
     */
    public function itThrowsExceptionWhenTokenIsExpired()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Token ' . $this->expiredBearerToken . ' is expired.');
        $this->authenticator->authenticate($this->expiredBearerToken);
    }
}
