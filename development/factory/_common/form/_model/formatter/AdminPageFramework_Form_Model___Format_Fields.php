<?php
/**
 * Admin Page Framework
 * 
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2022, Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides methods to format form sub-fields definition arrays.
 * 
 * The user defines a field with a field definition array. Sub-fields will be created from the field definition array 
 * when it has numerically indexed field definition elements or the `repeatable` argument is set to `true`.
 * 
 * @package  AdminPageFramework/Common/Form/Model/Format
 * @since    3.6.0
 * @internal
 */
class AdminPageFramework_Form_Model___Format_Fields extends AdminPageFramework_Form_Model___Format_FormField_Base {
    
    /**
     * Represents the structure of the sub-field definition array.
     */
    static public $aStructure = array();
    
    /**
     * @var array
     */
    public $aField      = array();
    public $aOptions    = array();
    
    /**
     * Sets up properties.
     */
    public function __construct( /* array $aField, array $aOptions */ ) {
        $_aParameters = func_get_args() + array(
            $this->aField, 
            $this->aOptions,
        );
        $this->aField           = $_aParameters[ 0 ];
        $this->aOptions         = $_aParameters[ 1 ];
    }

    /**
     * Formats an array holding sub-fields.
     * 
     * @return array A sub-fields definition array.
     */
    public function get() {

        // Get the set value(s)
        $_mSavedValue    = $this->___getStoredInputFieldValue( $this->aField, $this->aOptions );

        // Construct fields array.
        $_aFields = $this->___getFieldsWithSubs( $this->aField, $_mSavedValue );
             
        // Set the saved values
        $this->___setSavedFieldsValue( $_aFields, $_mSavedValue, $this->aField );

        // Determine the value
        $this->___setFieldsValue( $_aFields ); // passed by reference
        
        return $_aFields;
        
    }

        /**
         * Returns fields array which includes sub-fields.
         * 
         * @since 3.5.3
         * @since 3.6.0 Moved from `AdminPageFramework_FieldDefinition`.
         */
        private function ___getFieldsWithSubs( $aField, $mSavedValue ) {

            // Separate the first field and sub-fields
            $aFirstField    = array();
            $aSubFields     = array();
            
            // `$aFirstField` and `$aSubFields` get updated in the method
            $this->___divideMainAndSubFields( $aField, $aFirstField, $aSubFields );
                        
            // `$aSubFields` gets updated in the method
            $this->___fillRepeatableElements( $aField, $aSubFields, $mSavedValue );

            // `$aSubFields` gets updated in the method
            $this->___fillSubFields( $aSubFields, $aFirstField );

            // Put them together
            return array_merge( array( $aFirstField ), $aSubFields );
            
        }            
            /**
             * Divide the fields into the main field and sub fields.
             * 
             * @remark The method will update the arrays passed to the second and the third parameter.
             * @since  3.5.3
             * @since  3.6.0 Moved from `AdminPageFramework_FieldDefinition`.
             */
            private function ___divideMainAndSubFields( $aField, array &$aFirstField, array &$aSubFields ) {
                foreach( $aField as $_nsIndex => $_mFieldElement ) {
                    if ( is_numeric( $_nsIndex ) ) {
                        $aSubFields[] = $_mFieldElement;
                    } else {
                        $aFirstField[ $_nsIndex ] = $_mFieldElement;
                    }
                }     
            }   
            /**
             * Fills sub-fields with repeatable fields.
             * 
             * This method creates the sub-fields of repeatable fields based on the saved values.
             * 
             * @remark This method updates the passed array to the second parameter.
             * @since  3.5.3
             * @since  3.6.0 Moved from `AdminPageFramework_FieldDefinition`.
             */
            private function ___fillRepeatableElements( $aField, array &$aSubFields, $mSavedValue ) {

                if ( empty( $aField[ 'repeatable' ] ) ) {
                    return;
                }
                $_aSavedValues = ( array ) $mSavedValue;
                
                // We are collecting elements from the second sub-field.
                unset( $_aSavedValues[ 0 ] ); 
                   
                foreach( $_aSavedValues as $_iIndex => $vValue ) {
                    $aSubFields[ $_iIndex - 1 ] = isset( $aSubFields[ $_iIndex - 1 ] ) && is_array( $aSubFields[ $_iIndex - 1 ] )
                        ? $aSubFields[ $_iIndex - 1 ] 
                        : array();     
                }
                
            }
            /**
             * Fills sub-fields.
             * @since 3.5.3
             * @since 3.6.0 Moved from `AdminPageFramework_FieldDefinition`.
             */
            private function ___fillSubFields( array &$aSubFields, array $aFirstField ) {
                        
                foreach( $aSubFields as &$_aSubField ) {
                    
                    // Evacuate the label element which should not be merged.
                    $_aLabel = $this->getElement( 
                        $_aSubField, 
                        'label',
                        $this->getElement( $aFirstField, 'label', null )
                    );
                    
                    // Do recursive array merge - the 'attributes' array of some field types have more than one dimensions.
                    $_aSubField = $this->uniteArrays( $_aSubField, $aFirstField ); 

                    // Restore the label element.
                    $_aSubField[ 'label' ] = $_aLabel;
                    
                }
             
            }
            
        /**
         * Sets saved field values to the given field arrays.
         * 
         * @internal
         * @since    3.5.3
         * @since    3.6.0       Moved from `AdminPageFramework_FieldDefinition`.
         */
        private function ___setSavedFieldsValue( array &$aFields, $mSavedValue, $aField ) {
         
            // Determine whether the elements are saved in an array.
            // $_bHasSubFields = count( $aFields ) > 1 || $aField[ 'repeatable' ] || $aField[ 'sortable' ];
            if ( ! $this->hasSubFields( $aFields, $aField ) ) {
                $aFields[ 0 ][ '_saved_value' ] = $mSavedValue;
                $aFields[ 0 ][ '_is_multiple_fields' ] = false;
                return;                    
            }
     
            foreach( $aFields as $_iIndex => &$_aThisField ) {
                $_aThisField[ '_saved_value' ]        = $this->getElement( $mSavedValue, $_iIndex, null );
                $_aThisField[ '_subfield_index' ]     = $_iIndex;   // 3.8.0+
                $_aThisField[ '_is_multiple_fields' ] = true;
            }
    
        } 
        
        /**
         * Sets the value to the given fields array.
         * 
         * @since 3.5.3
         * @since 3.6.0 Moved from `AdminPageFramework_FieldDefinition`.
         */
        private function ___setFieldsValue( &$aFields ) {
            foreach( $aFields as &$_aField ) {
                $_aField[ '_is_value_set_by_user' ] = isset( $_aField[ 'value' ] );
                $_aField[ 'value' ]                 = $this->___getSetFieldValue( $_aField );
            }
        }
            /**
             * Returns the set field value.
             * 
             * @since 3.5.3
             * @since 3.6.0       Moved from `AdminPageFramework_FieldDefinition`.
             */
            private function ___getSetFieldValue( $aField ) {
                if ( isset( $aField[ 'value' ] ) ) {
                    return $aField[ 'value' ];
                }
                if ( isset( $aField[ '_saved_value' ] ) ) {
                    return $aField[ '_saved_value' ];
                }
                if ( isset( $aField[ 'default' ] ) ) {
                    return $aField[ 'default' ];
                }
                return null;                  
            }        
            
        /**
         * Returns the stored field value.
         * 
         * It checks if a previously saved option value exists or not. Regular setting pages and page meta boxes will be applied here.
         * It's important to return null if not set as the returned value will be checked later on whether it is set or not. 
         * If an empty value is returned, it will be considered the value is set.
         * 
         * @internal
         * @since    2.0.0
         * @since    3.0.0       Removed the check of the 'value' and 'default' keys. Made it use the '_fields_type' internal key.
         * @since    3.1.0       Changed the name to ___getStoredInputFieldValue from _getInputFieldValue
         * @since    3.4.1       Removed the switch block as it was redundant.
         * @since    3.6.0       Moved from `AdminPageFramework_FieldDefinition`.
         * @since    3.7.0       Changed the `_field_type` element to `_structure_type`.
         * @return   null|string|array
         */
        private function ___getStoredInputFieldValue( $aField, $aOptions ) {    

            $_aFieldPath   = $aField[ '_field_path_array' ];
        
            // If a section is not set, check the first dimension element.
            if ( ! isset( $aField[ 'section_id' ] ) || '_default' === $aField[ 'section_id' ] ) {
                return $this->getElement( 
                    $aOptions, 
                    $_aFieldPath, // $aField[ 'field_id' ],  // @todo this may have to be a field path instead of field id.
                    null
                );
            }
                
            // At this point, the section dimension is set.
            
            $_aSectionPath = $aField[ '_section_path_array' ];            
            
            // If it belongs to a sub section,
            if ( isset( $aField[ '_section_index' ] ) ) {
                return $this->getElement(
                    $aOptions,
                    array_merge( $_aSectionPath, array( $aField[ '_section_index' ] ), $_aFieldPath ),
                    null
                );
            }
            
            // Otherwise, return the second dimension element.
            return $this->getElement(
                $aOptions,
                array_merge( $_aSectionPath, $_aFieldPath ),
                null
            );
                                            
        }         
    
}