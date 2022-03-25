<?php

namespace Tests\OptiosAuthenticator\Provider;

use OptiosAuthenticator\Provider\MemoryProvider;
use OptiosAuthenticator\Token;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MemoryProviderTest extends TestCase
{
    /**
     * @var string
     */
    private $bearerToken;

    /**
     * @var MemoryProvider
     */
    private $provider;

    protected function setUp(): void
    {
        $this->bearerToken = Uuid::uuid4()->toString();

        $token = new Token(
            $this->bearerToken,
            new \DateTime('+1 hour'),
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
            1,
            'nl'
        );

        $this->provider = new MemoryProvider([$token]);

        parent::setUp();
    }

    /**
     * @test
     */
    public function itCanGetToken()
    {
        $this->assertNotNull($this->provider->getToken($this->bearerToken));
    }

    /**
     * @test
     */
    public function itReturnsNullIfNotFound()
    {
        $this->assertNull($this->provider->getToken(Uuid::uuid4()->toString()));
    }
}
