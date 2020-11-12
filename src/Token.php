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
     * @var string
     */
    private $establishmentUuid;
    /**
     * @var int
     */
    private $establishmentId;

    /**
     * Token constructor.
     *
     * @param string    $bearerToken
     * @param \DateTime $expiresAt
     * @param string    $organisationUuid
     * @param string    $establishmentUuid
     * @param int       $establishmentId
     */
    public function __construct(string $bearerToken, \DateTime $expiresAt, string $organisationUuid, string $establishmentUuid, int $establishmentId)
    {
        Assert::that($bearerToken)->uuid();
        Assert::that($organisationUuid)->uuid();

        $this->bearerToken       = $bearerToken;
        $this->expiresAt         = $expiresAt;
        $this->organisationUuid  = $organisationUuid;
        $this->establishmentUuid = $establishmentUuid;
        $this->establishmentId   = $establishmentId;
    }

    public static function create($array)
    {
        $self = new self(
            $array['bearer_token'] ?? $array['access_token'],
            \DateTime::createFromFormat('Y-m-d H:i:s', $array['expires_at']),
            $array['organisation_uuid'],
            $array['establishment_uuid'],
            (int) $array['establishment_id']
        );

        return $self;
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

    /**
     * @return string
     */
    public function getEstablishmentUuid(): string
    {
        return $this->establishmentUuid;
    }

    /**
     * @return int
     */
    public function getEstablishmentId(): int
    {
        return $this->establishmentId;
    }
}
