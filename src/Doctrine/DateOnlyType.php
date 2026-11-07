<?php

declare(strict_types=1);

namespace App\Doctrine;

use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;

final class DateOnlyType extends DateType
{
    public const NAME = 'date_only';

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?DateTime
    {
        // SQLite may contain timestamps written by a database editor into a DATE column.
        if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}(?:\.\d+)?$/D', $value) === 1) {
            $value = substr($value, 0, 10);
        }

        return parent::convertToPHPValue($value, $platform);
    }
}
