<?php
/**
 Admin Page Framework v3.7.4b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_Format_SubMenuItem extends AdminPageFramework_Format_Base {
    static public $aStructure = array();
    public $aSubMenuItem = array();
    public $oFactory;
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aSubMenuItem, $this->oFactory,);
        $this->aSubMenuItem = $_aParameters[0];
        $this->oFactory = $_aParameters[1];
    }
    public function get() {
        $_aSubMenuItem = $this->getAsArray($this->aSubMenuItem);
        if (isset($_aSubMenuItem['page_slug'])) {
            $_oFormatter = new AdminPageFramework_Format_SubMenuPage($_aSubMenuItem, $this->oFactory);
            return $_oFormatter->get();
        }
        if (isset($_aSubMenuItem['href'])) {
            $_oFormatter = new AdminPageFramework_Format_SubMenuLink($_aSubMenuItem, $this->oFactory);
            return $_oFormatter->get();
        }
        return array();
    }
}