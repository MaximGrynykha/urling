<?php

namespace Urling\Core\Utilities\Misc;

trait SwissKnife
{
    /**
     * @param string $resource
     *
     * @return string
     */
    public static function truncateExtraSlashes(string $resource): string
    {
        return str_replace(':/', '://', trim(preg_replace('/\/+/', '/', $resource), '/'));
    }

    /**
     * @param string $string
     * @param string $_string
     *
     * @return bool
     */
    public static function isSameStrings(string $string, string $_string): bool
    {
        return !strcmp($string, $_string);
    }

    /**
     * @return bool
     */
    public static function isUppercased(string $string): bool
    {
        return self::isSameStrings(mb_strtoupper($string), $string);
    }

    /**
     * @return bool
     */
    public static function isLowercased(string $string): bool
    {
        return self::isSameStrings(mb_strtolower($string), $string);
    }
}