<?php declare(strict_types=1);

namespace OptiosAuthenticator\Helper;

class DateHelper
{
    /**
     * @return \DateTime
     * @throws \Exception
     */
    public static function now(): \DateTime
    {
        return new \DateTime('now', new \DateTimeZone('UTC'));
    }
}
