<?php
/**
 * Admin Page Framework
 * 
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2021, Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides shared methods for the form classes.
 * 
 * @package     AdminPageFramework/Common/Form/Utility
 * @since       3.7.0
 * @extends     AdminPageFramework_FrameworkUtility
 * @internal
 */
abstract class AdminPageFramework_Form_Utility extends AdminPageFramework_FrameworkUtility {

    /**
     * Removes form input elements whose 'save' argument is false.
     *
     * The inputs array structure looks like the following.
     * ```
     *     [example_section] => Array
     *       (
     *           [example_text] => (string, length: 5) hello
     *           [__submit] => (string, length: 6) Submit
     *       )
     * ```
     * The unset keys stored in $_POST looks like the following. The pipe (|) character is used to delimit dimensional elements.
     * ```
     *   [example_section|example_text] => (string, length: 28) example_section|example_text
     *   [example_section|__submit] => (string, length: 24) example_section|__submit
     * ```
     *
     * @return      array
     * @since       3.8.17
     * @param       array       $aInputs        The inputs array to parse.
     * @param       string      $sFieldsType    The subject fields type (factory structure type).
     * @param       integer     $iSkipDepth     The dimensional depth to skip.
     * Depending on the fields type (structure type), dimensional keys are prepended.
     * For the `admin_page` fields type, an option key is prepended.
     * For `page_meta_box`, no prepended element and it starts with the section or field ID.
     */
    static public function getInputsUnset( array $aInputs, $sFieldsType, $iSkipDepth=0 ) {

        $_sUnsetKey = '__unset_' . $sFieldsType;
        if ( ! isset( $_POST[ $_sUnsetKey ] ) ) {
            return $aInputs;
        }

        $_aUnsetElements = array_unique( $_POST[ $_sUnsetKey ] );
        foreach( $_aUnsetElements as $_sFlatInputName ) {

            $_aDimensionalKeys = explode( '|', $_sFlatInputName );

            // For form sections, a dummy key is set
            if ( '__dummy_option_key' === $_aDimensionalKeys[ 0 ] ) {
                 array_shift( $_aDimensionalKeys );
            }

            // The first element is the option key for the `admin_page` field type and section or field dimensional keys follow.
            for ( $_i = 0; $_i < $iSkipDepth; $_i++) {
                unset( $_aDimensionalKeys[ $_i ] );
            }

            self::unsetDimensionalArrayElement(
                $aInputs,
                $_aDimensionalKeys
            );

        }

        return $aInputs;

    }


    /**
     * @since       3.7.0
     * @return      array
     */
    static public function getElementPathAsArray( $asPath ) {
        if ( is_array( $asPath ) ) {
            return;
        }
        return explode( '|', $asPath );
    }
    
    /**
     * @since       3.7.0
     * @return      string      The section path. e.g. my_section|nested_section
     */
    static public function getFormElementPath( $asID ) {
        return implode( 
            '|', 
            self::getAsArray( $asID ) 
        );        
    }
  
    /**
     * Sanitizes a given section or field id.
     * @return      array|string
     * @since       3.7.0
     */
    static public function getIDSanitized( $asID ) {
        return is_scalar( $asID )
            ? self::sanitizeSlug( $asID )
            : self::getAsArray( $asID );
            
    }
    
    /**
     * Checks whether the given field-set definition has nested field items.
     * @since       3.8.0
     * @return      boolean
     */
    static public function hasNestedFields( $aFieldset ) {
        
        if ( ! self::hasFieldDefinitionsInContent( $aFieldset ) ) {
            return false;
        }
        // At this point, the `content` argument contains either the definition of nested fields or inline-mixed fields.
        
        // If it is the `inline_mixed` field type, yield false.
        if ( 'inline_mixed' === self::getElement( $aFieldset, 'type' ) ) {
            return false;
        }
        
        // If the first element is a string, it is an inline mixed field definition.
       return is_array( self::getElement( $aFieldset[ 'content' ], 0 ) );
       
    }  

    /**
     * Checks whether the given field-set definition has field-set definitions in the `content` argument.
     * @since       3.8.0
     * @return      boolean
     */
    static public function hasFieldDefinitionsInContent( $aFieldset ) {
        
        if ( ! isset( $aFieldset[ 'content' ] ) ) {
            return false;
        }
        if ( empty( $aFieldset[ 'content' ] ) ) {
            return false;
        }
        return is_array( $aFieldset[ 'content' ] );            
        
    }
    
    /**
     * Checks whether the given field has a sub-field.
     * @since       3.8.0
     * @param       array       $aFields        An array holding sub-fields.
     * @param       array       $aField         A field definition array. 
     * @return      boolean
     */
    static public function hasSubFields( array $aFields, $aField ) {
        
        if ( count( $aFields ) > 1 ) {
            return true;
        }
        if ( self::isDynamicField( $aField ) ) {
            return true;
        }
        return false;
        
    }

    /**
     * Checks whether the given field is dynamic.
     * @return      boolean
     * @since       3.8.13
     */
    static public function isDynamicField( $aField ) {
        if ( ! empty( $aField[ 'repeatable' ] ) ) {
            return true;
        }
        if ( ! empty( $aField[ 'sortable' ] ) ) {
            return true;
        }
        return false;
    }
    
    /**
     * Checks whether the parent field is repeatable or sortable.
     * 
     * @since       3.8.0
     * @return      boolean
     * @deprecated  3.8.0
     */
    // static public function isParentFieldDynamic( $aFieldset ) {
// return false;        
    // }

    /**
     * Adds a trailing pipe (|) character to the given string value.
     *
     * Used to construct a field path.
     *
     * @return      string
     * @since       3.8.0
     */
    static public function getTrailingPipeCharacterAppended( $sString ) {
        if ( empty( $sString ) ) {
            return $sString;
        }
        return $sString . '|';
    }

    /**
     * Re-formats the field-set definition with the passed sub-field index. The field path and other internal keys need to be updated to insert a sub-field index.
     *
     * It is assumed that the passed field-set definition array is already formatted as this is for sub-fields of nested field-sets.
     *
     * This is used for nested and inline-mixed field types.
     *
     * @internal
     * @since       3.8.0
     * @return      array
     */
    static public function getFieldsetReformattedBySubFieldIndex( $aFieldset, $iSubFieldIndex, $bHasSubFields, $aParentFieldset ) {

        $_oCallerForm   = $aFieldset[ '_caller_object' ];

        // Add sub-field index to the parent field path for repeated nested items.
        $aFieldset[ '_parent_field_path' ]   = self::getAOrB(
            $bHasSubFields,
            $aFieldset[ '_parent_field_path' ] . '|' . $iSubFieldIndex,
            $aFieldset[ '_parent_field_path' ]
        );
        $aFieldset[ '_parent_tag_id' ]       = self::getAOrB(
            $bHasSubFields,
            $aParentFieldset[ 'tag_id' ] . '__' . $iSubFieldIndex,
            $aParentFieldset[ 'tag_id' ]
        );

        // Re-format the field-set definition array to re-construct field path and relevant attribute IDs and names.
        $_oFieldsetFormatter = new AdminPageFramework_Form_Model___Format_Fieldset(
            $aFieldset,
            $aFieldset[ '_structure_type' ],
            $aFieldset[ 'capability' ],
            ( integer ) $iSubFieldIndex + 1,   // 1-based count (not index)
            $aFieldset[ '_subsection_index' ],
            $aFieldset[ '_is_section_repeatable' ],
            $aFieldset[ '_caller_object' ]
        );
        $aFieldset = $_oFieldsetFormatter->get();

        $_oFieldsetOutputFormatter = new AdminPageFramework_Form_Model___Format_FieldsetOutput(
            $aFieldset,
            $aFieldset[ '_section_index' ],    // `_section_index` is defined in the ...FieldsetOutput class. Since this is a nested item, it should be already set.
            $_oCallerForm->aFieldTypeDefinitions
        );
        return $_oFieldsetOutputFormatter->get();

    }

    /**
     * Checks whether the field placement is normal.
     *
     * @since       3.8.0
     * @internal
     * @return      boolean
     */
    static public function isNormalPlacement( array $aFieldset ) {

        if ( 'section_title' === $aFieldset[ 'type' ] ) {
            return false;
        }
        return 'normal' === $aFieldset[ 'placement' ];

    }

    /**
     * Generates an HTML element for the WordPress modal window to display user-defined message
     * for disabled repeatable elements including repeatable sections and fields.
     *
     * @since   3.8.13
     * @param   string  $sBoxElementID
     * @param   array   $aArguments         The `disabled` argument of a repeatable field/section.
     * @return  string  A generated container element for the modal window.
     */
    static public function getModalForDisabledRepeatableElement( $sBoxElementID, $aArguments ) {

        if ( empty( $aArguments ) ) {
            return '';
        }
        if ( self::hasBeenCalled( 'disabled_repeatable_elements_modal_' . $sBoxElementID ) ) {
            return '';
        }
        add_thickbox(); // to display a message to the user.
        return "<div id='{$sBoxElementID}' style='display:none'>"
                . "<p>" . $aArguments[ 'message' ] . "</p>"
            . "</div>";

    }
    
}
