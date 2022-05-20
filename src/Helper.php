<?php declare(strict_types=1);

namespace VVOphp;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class Helper
{
    /**-
     * Convert Date-string ("/Date(1653045480000+0200)/") from API to DateTime
     * Caution: converts automaticly to Europe/Berlin Timezone
     * @param string $JSONDate
     * @param bool $ignorePassedTimezone
     * @return DateTimeInterface
     */
    public static function getDateFromJSON(string $JSONDate, bool $ignorePassedTimezone = true): DateTimeInterface
    {
        preg_match('~(\d+)\d{3}((?:\+|-)\d+)~', $JSONDate, $expDate);
        $ret = DateTime::createFromFormat('U', $expDate[1]);
        if ($ret instanceof DateTimeInterface) {
            if ($ignorePassedTimezone) {
                $ret->setTimezone(new DateTimeZone('Europe/Berlin'));
            } else {
                $ret->setTimezone($expDate[2]);
            }
            return $ret;
        }
        return new DateTimeImmutable('2000-01-01');
    }
}