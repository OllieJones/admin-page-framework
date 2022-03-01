<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2022, Michael Uno; Licensed MIT
 *
 */

/**
 * Provides abstract methods to format and generate field container HTML attributes.
 *
 * @package     AdminPageFramework/Common/Form/View/Attribute
 * @since       3.6.0
 * @extends     AdminPageFramework_Form_View___Attribute_Base
 * @internal
 */
abstract class AdminPageFramework_Form_View___Attribute_FieldContainer_Base extends AdminPageFramework_Form_View___Attribute_Base {

    /**
     * Formats attributes array.
     * @since       3.0.0
     * @since       3.3.1       Changed the name from `_getAttributes()`. Added the <var>$sContext</var> parameter. Moved from `AdminPageFramework_FormPart_Table_Base`.
     * @since       3.6.0       Moved from `AdminPageFramework_FormOutput`.
     * @return      array       The formatted attributes array.
     */
    protected function _getFormattedAttributes() {

        // 3.3.1+ Changed the custom attributes to take its precedence.
        $_aAttributes = $this->uniteArrays(
            $this->getElementAsArray( $this->aArguments, array( 'attributes', $this->sContext ) ),
            $this->aAttributes + $this->_getAttributes()
        );

        $_aAttributes[ 'class' ]   = $this->getClassAttribute(
            $this->getElement( $_aAttributes, 'class', array() ),
            $this->getElement( $this->aArguments, array( 'class', $this->sContext ), array() )
        );

        return $_aAttributes;

    }

}
