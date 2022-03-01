<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2022, Michael Uno; Licensed MIT
 *
 */

/**
 * Put deprecated utility methods together.
 *
 * @since       3.5.3
 * @package     AdminPageFramework/Utility
 * @internal
 * @deprecated
 */
abstract class AdminPageFramework_Utility_Deprecated {

    /**
     * @deprecated     3.7.10      Use `getCSSMinified()` instead.
     * @since          3.8.8       Moved from `AdminPageFramework_Utility_String`.
     */
    static public function minifyCSS( $sCSSRules ) {
        AdminPageFramework_Utility::showDeprecationNotice( __FUNCTION__, 'getCSSMinified()' );
        return AdminPageFramework_Utility_String::getCSSMinified( $sCSSRules );
    }

    /**
     * @deprecated  3.8.0       Use `getLengthSanitized()` instead.
     * @since       3.8.8       Moved from `AdminPageFramework_Utility_String`.
     */
    static public function sanitizeLength( $sLength, $sUnit='px' ) {
        AdminPageFramework_Utility::showDeprecationNotice( __FUNCTION__, 'getLengthSanitized()' );
        return AdminPageFramework_Utility_String::getLengthSanitized( $sLength, $sUnit );
    }

    /**
     * Retrieves a corresponding array value from the given array.
     *
     * When there are multiple arrays and they have similar index structures but it's not certain if one has the key and the others,
     * use this method to retrieve the corresponding key value.
     *
     * @remark      This is mainly used by the field array to insert user-defined key values.
     * @return      string|array    If the key does not exist in the passed array, it will return the default. If the subject value is not an array, it will return the subject value itself.
     * @since       2.0.0
     * @since       2.1.3           Added the $bBlankToDefault parameter that sets the default value if the subject value is empty.
     * @since       2.1.5           Changed the scope to public static from protected as converting all the utility methods to all public static.
     * @since       3.5.3           Moved from `AdminPageFramework_Utility_Array`.
     * @deprecated  3.5.3           Use `getElement()`.
     */
    public static function getCorrespondingArrayValue( $vSubject, $sKey, $sDefault='', $bBlankToDefault=false ) {

        AdminPageFramework_Utility::showDeprecationNotice( __FUNCTION__, 'getElement()' );

        // If $vSubject is null,
        if ( ! isset( $vSubject ) ) {
            return $sDefault;
        }

        // If the $bBlankToDefault flag is set and the subject value is a blank string, return the default value.
        if ( $bBlankToDefault && $vSubject == '' ) {
            return  $sDefault;
        }

        // If $vSubject is not an array,
        if ( ! is_array( $vSubject ) ) {
            return ( string ) $vSubject;
        } // consider it as string.

        // Consider $vSubject as array.
        if ( isset( $vSubject[ $sKey ] ) ) {
            return $vSubject[ $sKey ];
        }

        return $sDefault;

    }

    /**
     * Finds the dimension depth of the given array.
     *
     * @since       2.0.0
     * @since       3.5.3           Moved from `AdminPageFramework_Utility_Array`.
     * @remark      There is a limitation that this only checks the first element so if the second or other elements have deeper dimensions, it will not be caught.
     * @param       array           $array     the subject array to check.
     * @return      integer         returns the number of dimensions of the array.
     * @deprecated  3.5.3
     */
    public static function getArrayDimension( $array ) {
        AdminPageFramework_Utility::showDeprecationNotice( __FUNCTION__ );
        return ( is_array( reset( $array ) ) )
            ? self::getArrayDimension( reset( $array ) ) + 1
            : 1;
    }

    /**
     * Returns the element value of the given field element.
     *
     * When there are multiple input/select tags in one field such as for the radio and checkbox input type,
     * the framework user can specify the key to apply the element value. In this case, this method will be used.
     *
     * @since       3.0.0
     * @since       3.5.3       Moved from `AdminPageFramework_FieldType_Base`.
     * @deprecated  3.5.3       Use the `getElement()` method.
     */
    protected function getFieldElementByKey( $asElement, $sKey, $asDefault='' ) {

        AdminPageFramework_Utility::showDeprecationNotice( __FUNCTION__, 'getElement()' );

        if ( ! is_array( $asElement ) || ! isset( $sKey ) ) {
            return $asElement;
        }

        $aElements = &$asElement; // it is an array
        return isset( $aElements[ $sKey ] )
            ? $aElements[ $sKey ]
            : $asDefault;

    }

    /**
     * Shift array elements until it gets an element that yields true and re-index with numeric keys.
     *
     * @since       3.0.1
     * @since       3.5.3       Moved from `AdminPageFramework_Utility_Array`.
     * @deprecated  3.5.3       This was used to sanitise dimensional key arrays but it does not seem to necessary.
     * @return      array
     */
    static public function shiftTillTrue( array $aArray ) {

        AdminPageFramework_Utility::showDeprecationNotice( __FUNCTION__ );

        foreach( $aArray as &$vElem ) {

            if ( $vElem ) { break; }
            unset( $vElem );

        }
        return array_values( $aArray );

    }

}
