<?php
/*
 * Admin Page Framework v3.9.1b01 by Michael Uno
 * Compiled with Admin Page Framework Compiler <https://github.com/michaeluno/admin-page-framework-compiler>
 * <https://en.michaeluno.jp/admin-page-framework>
 * Copyright (c) 2013-2022, Michael Uno; Licensed under MIT <https://opensource.org/licenses/MIT>
 */

abstract class AdminPageFramework_FieldType extends AdminPageFramework_FieldType_Base {
    public function _replyToFieldLoader()
    {
        $this->setUp();
    }
    public function _replyToGetScripts()
    {
        return $this->getScripts();
    }
    public function _replyToGetInputIEStyles()
    {
        return $this->getIEStyles();
    }
    public function _replyToGetStyles()
    {
        return $this->getStyles();
    }
    public function _replyToGetField($aField)
    {
        return $this->getField($aField);
    }
    public function _replyToDoOnFieldRegistration($aField)
    {
        $this->doOnFieldRegistration($aField);
    }
    protected function _replyToGetEnqueuingScripts()
    {
        return $this->getEnqueuingScripts();
    }
    protected function _replyToGetEnqueuingStyles()
    {
        return $this->getEnqueuingStyles();
    }
    public $aFieldTypeSlugs = array( 'default', );
    protected $aDefaultKeys = array();
    protected function construct()
    {}
    protected function setUp()
    {}
    protected function getScripts()
    {
        return '';
    }
    protected function getIEStyles()
    {
        return '';
    }
    protected function getStyles()
    {
        return '';
    }
    protected function getField($aField)
    {
        return '';
    }
    protected function getEnqueuingScripts()
    {
        return array();
    }
    protected function getEnqueuingStyles()
    {
        return array();
    }
    protected function doOnFieldRegistration($aField)
    {}
}
