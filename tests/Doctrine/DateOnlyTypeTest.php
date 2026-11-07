<?php

declare(strict_types=1);

namespace App\Tests\Doctrine;

use App\Doctrine\DateOnlyType;
use DateTime;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use PHPUnit\Framework\TestCase;

final class DateOnlyTypeTest extends TestCase
{
    public function testReadsDatesAndEditorTimestampsAsDateOnly(): void
    {
        $type = new DateOnlyType();
        $platform = new SQLitePlatform();

        foreach (['2026-11-08', '2026-11-08 15:23:45', '2026-11-08 15:23:45.000'] as $value) {
            self::assertSame('2026-11-08 00:00:00', $type->convertToPHPValue($value, $platform)?->format('Y-m-d H:i:s'));
        }

        self::assertNull($type->convertToPHPValue(null, $platform));
        self::assertSame('2026-11-08', $type->convertToDatabaseValue(new DateTime('2026-11-08 15:23:45'), $platform));
    }

    public function testRejectsUnrecognizedValues(): void
    {
        $this->expectException(InvalidFormat::class);
        (new DateOnlyType())->convertToPHPValue('2026-11-08 invalid', new SQLitePlatform());
    }
}
