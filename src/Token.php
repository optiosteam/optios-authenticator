<?php declare(strict_types = 1);

namespace OptiosAuthenticator;

use Assert\Assert;
use OptiosAuthenticator\Helper\DateHelper;

class Token
{
    /**
     * @var string
     */
    private $bearerToken;

    /**
     * @var \DateTime
     */
    private $expiresAt;

    /**
     * @var string
     */
    private $organisationUuid;

    /**
     * Token constructor.
     *
     * @param string    $bearerToken
     * @param \DateTime $expiresAt
     * @param string    $organisationUuid
     */
    public function __construct(string $bearerToken, \DateTime $expiresAt, string $organisationUuid)
    {
        Assert::that($bearerToken)->uuid();
        Assert::that($organisationUuid)->uuid();

        $this->bearerToken      = $bearerToken;
        $this->expiresAt        = $expiresAt;
        $this->organisationUuid = $organisationUuid;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expiresAt < DateHelper::now();
    }

    /**
     * @return string
     */
    public function getBearerToken(): string
    {
        return $this->bearerToken;
    }

    /**
     * @return string
     */
    public function getOrganisationUuid(): string
    {
        return $this->organisationUuid;
    }
}
