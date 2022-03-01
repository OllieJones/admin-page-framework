<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2022, Michael Uno; Licensed MIT
 *
 */

/**
 * A set of radio buttons that lets the user pick an option.
 *
 * This class defines the radio field type.
 *
 * <h3>Common Field Definition Arguments</h3>
 * For common field definition arguments, see {@link AdminPageFramework_Factory_Controller::addSettingField()}.
 *
 * <h2>Example</h2>
 * <code>
 *  array(
 *      'field_id'      => 'radio',
 *      'title'         => __( 'Radio Button', 'admin-page-framework-loader' ),
 *      'type'          => 'radio',
 *      'label'         => array(
 *          'a' => 'Apple',
 *          'b' => 'Banana ( this option is disabled. )',
 *          'c' => 'Cherry'
 *      ),
 *      'default'       => 'c', // yields Cherry; its key is specified.
 *      'after_label'   => '<br />',
 *      'attributes'    => array(
 *          'b' => array(
 *              'disabled' => 'disabled',
 *          ),
 *      ),
 *  )
 * </code>
 *
 * @image   http://admin-page-framework.michaeluno.jp/image/common/form/field_type/radio.png
 * @package AdminPageFramework/Common/Form/FieldType
 * @since   2.1.5
 * @since   3.3.1       Changed to extend `AdminPageFramework_FieldType` from `AdminPageFramework_FieldType_Base`.
 */
class AdminPageFramework_FieldType_radio extends AdminPageFramework_FieldType {

    /**
     * Defines the field type slugs used for this field type.
     */
    public $aFieldTypeSlugs = array( 'radio' );

    /**
     * Defines the default key-values of this field type.
     */
    protected $aDefaultKeys = array(
        'label'         => array(),
        'attributes'    => array(),
    );

    /**
     * @return array
     * @since  3.9.0
     */
    protected function getEnqueuingScripts() {
        return array(
            array(
                'handle_id'         => 'admin-page-framework-field-type-radio',
                'src'               => dirname( __FILE__ ) . '/js/radio.bundle.js',
                'in_footer'         => true,
                'dependencies'      => array( 'jquery', 'admin-page-framework-script-form-main' ),
                'translation_var'   => 'AdminPageFrameworkFieldTypeRadio',
                'translation'       => array(
                    'fieldTypeSlugs' => $this->aFieldTypeSlugs,
                    'messages'       => array(),
                ),
            ),
        );
    }

    /**
     * Returns the output of the field type.
     *
     * @since       2.1.5
     * @since       3.0.0     Removed unnecessary parameters.
     * @since       3.3.1     Changed from `_replyToGetField()`.
     * @internal
     * @return      string
     */
    protected function getField( $aField ) {
        $_aOutput   = array();
        foreach( $this->getAsArray( $aField[ 'label' ] ) as $_sKey => $_sLabel ) {
            $_aOutput[] = $this->___getEachRadioButtonOutput( $aField, $_sKey, $_sLabel );
        }
        return implode( PHP_EOL, $_aOutput );
    }
        /**
         * Returns an HTML output of a single radio button.
         * @since       3.5.3
         * @internal
         * @return      string      The generated HTML output of the radio button.
         */
        private function ___getEachRadioButtonOutput( array $aField, $sKey, $sLabel ) {

            $_aAttributes = $aField[ 'attributes' ] + $this->getElementAsArray( $aField, array( 'attributes', $sKey ) );
            $_oRadio      = new AdminPageFramework_Input_radio( $_aAttributes );
            $_oRadio->setAttributesByKey( $sKey );
            $_oRadio->setAttribute( 'data-default', $aField[ 'default' ] ); // refered by the repeater script
            $_oRadio->addClass( 'admin-page-framework-input-radio' );

            // Output
            return $this->getElementByLabel( $aField[ 'before_label' ], $sKey, $aField[ 'label' ] )
                . "<div " . $this->getLabelContainerAttributes( $aField, 'admin-page-framework-input-label-container admin-page-framework-radio-label' ) . ">"
                    . "<label " . $this->getAttributes(
                            array(
                                'for'   => $_oRadio->getAttribute( 'id' ),
                                'class' => $_oRadio->getAttribute( 'disabled' )
                                    ? 'disabled'
                                    : null, // important to set null not '' as generateAttributes will not drop the element if it is ''
                            )
                        )
                    . ">"
                        . $this->getElementByLabel( $aField[ 'before_input' ], $sKey, $aField[ 'label' ] )
                        . $_oRadio->get( $sLabel )
                        . $this->getElementByLabel( $aField[ 'after_input' ], $sKey, $aField[ 'label' ] )
                    . "</label>"
                . "</div>"
                . $this->getElementByLabel( $aField[ 'after_label' ], $sKey, $aField[ 'label' ] )
                ;

        }

}