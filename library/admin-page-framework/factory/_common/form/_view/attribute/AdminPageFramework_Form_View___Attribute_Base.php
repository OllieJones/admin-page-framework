<?php
/**
 Admin Page Framework v3.7.3 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_Form_View___Attribute_Base extends AdminPageFramework_FrameworkUtility {
    public $sContext = '';
    public $aArguments = array();
    public $aAttributes = array();
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aArguments, $this->aAttributes,);
        $this->aArguments = $_aParameters[0];
        $this->aAttributes = $_aParameters[1];
    }
    public function get() {
        return $this->getAttributes($this->_getFormattedAttributes());
    }
    protected function _getFormattedAttributes() {
        return $this->aAttributes + $this->_getAttributes();
    }
    protected function _getAttributes() {
        return array();
    }
}