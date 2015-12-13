<?php
/**
 Admin Page Framework v3.7.3 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_FrameworkUtility extends AdminPageFramework_WPUtility {
    static public function getFrameworkVersion($bTrimDevVer = false) {
        $_sVersion = AdminPageFramework_Registry::getVersion();
        return $bTrimDevVer ? self::getSuffixRemoved($_sVersion, '.dev') : $_sVersion;
    }
    static public function getFrameworkName() {
        return AdminPageFramework_Registry::NAME;
    }
}