<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2021, Michael Uno; Licensed MIT
 *
 */

/**
 * Provides utility methods dealing with strings which do not use WordPress functions.
 *
 * @since       2.0.0
 * @package     AdminPageFramework/Utility
 * @internal
 */
abstract class AdminPageFramework_Utility_String extends AdminPageFramework_Utility_VariableType {

    /**
     * Get a value as a string.
     *
     * This is used when dealing with a function that returns mixed value types and wanting a string value, for example to concatenate strings.
     *
     * @param  mixed  $mValue
     * @return string
     * @since  3.9.0
     */
    static public function getAsString( $mValue ) {
        if ( is_string( $mValue ) ) {
            return $mValue;
        }
        if ( is_scalar( $mValue ) ) {
            return ( string ) $mValue;
        }
        // if null or false,
        if ( empty( $mValue ) ) {
            return '';
        }
        // Convert it to string
        return ( string ) $mValue;
    }

    /**
     * Returns the width for HTML attributes.
     *
     * When a value may be a number with a unit like, '100%', it returns the value itself.
     * When a value misses a unit like '60', it returns with the unit such as '60%'.
     *
     * ```
     * 0        -> '0px'
     * '0'      -> '0px'
     * null     -> '0px'
     * ''       -> '0px'
     * false    -> '0px'
     * ```
     *
     * @since       3.1.1
     * @since       3.8.0   Renamed from `sanitizeLength()`.
     * @since       3.8.4   When non-true value is passed, `0px` will be returned.
     * @return      string
     */
    static public function getLengthSanitized( $sLength, $sUnit='px' ) {
        $sLength = $sLength ? $sLength : 0;
        return is_numeric( $sLength )
            ? $sLength . $sUnit
            : $sLength;
    }

    /**
     * Converts non-alphabetic characters to underscore.
     *
     * @since       2.0.0
     * @return      string|null     The sanitized string.
     * @todo        Change the method name as it does not tell for what it will sanitized.
     * @todo        Examine why null needs to be returned.
     */
    public static function sanitizeSlug( $sSlug ) {
        return is_null( $sSlug )
            ? null
            : preg_replace( '/[^a-zA-Z0-9_\x7f-\xff]/', '_', trim( $sSlug ) );
    }

    /**
     * Converts non-alphabetic characters to underscore except hyphen(dash).
     *
     * @since       2.0.0
     * @return      string|null      The sanitized string.
     * @todo        Change the method name as it does not tell for what it will sanitized.
     * @todo        Examine why null needs to be returned.
     */
    public static function sanitizeString( $sString ) {
        return is_null( $sString )
            ? null
            : preg_replace( '/[^a-zA-Z0-9_\x7f-\xff\-]/', '_', $sString );
    }

    /**
     * Checks if the passed value is a number and sets it to the default if not.
     *
     * This is useful for form data validation. If it is a number and exceeds a set maximum number,
     * it sets it to the maximum value. If it is a number and is below the minimum number, it sets to the minimum value.
     * Set a blank value for no limit.
     *
     * @since       3.8.11      Renamed from `fixNumber()`.
     * @return      string|integer      A numeric value will be returned.
     */
    static public function getNumberFixed( $nToFix, $nDefault, $nMin='', $nMax='' ) {

        if ( ! is_numeric( trim( $nToFix ) ) ) {
            return $nDefault;
        }
        if ( $nMin !== '' && $nToFix < $nMin ) {
            return $nMin;
        }
        if ( $nMax !== '' && $nToFix > $nMax ) {
            return $nMax;
        }
        return $nToFix;

    }
        /**
         * An alias of `getNumberFixed()`.
         * @since       2.0.0
         * @return      string|integer      A numeric value will be returned.
         * @deprecated  3.8.11
         */
        static public function fixNumber( $nToFix, $nDefault, $nMin='', $nMax='' ) {
            return self::getNumberFixed( $nToFix, $nDefault, $nMin, $nMax );
        }

    /**
     * Compresses CSS rules.
     *
     * @since       3.0.0
     * @since       3.7.10      Changed the name from `minifyCSS()`.
     * @return      string
     */
    static public function getCSSMinified( $sCSSRules ) {
        return str_replace(
            array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    '),  // remove line breaks, tab, and white sspaces.
            '',
            preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $sCSSRules ) // remove comments
        );
    }

    /**
     * Returns the given string length.
     * @since       3.3.0
     * @return      integer|null        Null if an array is given.
     */
    static public function getStringLength( $sString ) {
        return function_exists( 'mb_strlen' )
            ? mb_strlen( $sString )
            : strlen( $sString );
    }

    /**
     * Returns a number from the given human readable size representation.
     *
     * For example,
     * ```
     * 20M   -> 20971520
     * 324k  -> 331776
     * ```
     *
     * Only a single character for the unit is allowed. So ~MB will not be recognized and only the first letter will be left.
     * ```
     * 20MB  -> '20M'
     * 42KB  -> '42K'
     * ```
     *
     * @since       3.4.6
     * @return      string|integer
     */
    static public function getNumberOfReadableSize( $nSize ) {

        $_nReturn     = substr( $nSize, 0, -1 );
        switch( strtoupper( substr( $nSize, -1 ) ) ) {
            case 'P':
                $_nReturn *= 1024;
            case 'T':
                $_nReturn *= 1024;
            case 'G':
                $_nReturn *= 1024;
            case 'M':
                $_nReturn *= 1024;
            case 'K':
                $_nReturn *= 1024;
        }
        return $_nReturn;

    }

    /**
     * Returns a human readable size from the given byte number.
     * @param  integer $iRoundPrecision
     * @param  integer|float $nBytes
     * @since       3.4.6
     * @since       3.8.26 Added the `$iRoundPrecision` parameter.
     * @return      string
     */
    static public function getReadableBytes( $nBytes, $iRoundPrecision=2 ) {
        $_aUnits = array( 0 => 'B', 1 => 'kB', 2 => 'MB', 3 => 'GB' );
        $_nLog   = log( $nBytes, 1024 );
        $_iPower = ( int ) $_nLog;
        $_ifSize = pow( 1024, $_nLog - $_iPower );
        $_ifSize = round( $_ifSize, $iRoundPrecision );
        return $_ifSize . $_aUnits[ $_iPower ];
    }

    /**
     * Trims a starting sub-string if exists.
     * @return      string
     * @since       3.7.2
     */
    static public function getPrefixRemoved( $sString, $sPrefix ) {
        return self::hasPrefix( $sPrefix, $sString )
            ? substr( $sString, strlen( $sPrefix ) )
            : $sString;
    }
    /**
     * Trims a trailing sub-string if exists.
     * @return      string
     * @since       3.7.2
     */
    static public function getSuffixRemoved( $sString, $sSuffix ) {
        return self::hasSuffix( $sSuffix, $sString )
            ? substr( $sString, 0, strlen( $sSuffix ) * - 1 )
            : $sString;
    }

    /**
     * Checks if the given string has a certain prefix.
     *
     * Used mainly in the __call() method to determine the called undefined method name has a certain prefix.
     *
     * @since       3.5.3
     * @return      boolean     True if it has the given prefix; otherwise, false.
     */
    static public function hasPrefix( $sNeedle, $sHaystack ) {
        return ( string ) $sNeedle === substr( $sHaystack, 0, strlen( ( string ) $sNeedle ) );
    }

    /**
     * Checks if the given string has a certain suffix.
     *
     * Used to check file base name etc.
     *
     * @since   3.5.4
     * @return  boolean
     */
    static public function hasSuffix( $sNeedle, $sHaystack ) {

        $_iLength = strlen( ( string ) $sNeedle );
        if ( 0 === $_iLength ) {
            return true;
        }
        return substr( $sHaystack, - $_iLength ) === $sNeedle;

    }

    /**
     * Checks if a given string has back/forward slashes.
     * @param string $sString
     * @return boolean
     */
    static public function hasSlash( $sString ) {
        $sString = str_replace( '\\', '/', $sString );
        return ( false !== strpos( $sString, '/' ) );
    }

}
