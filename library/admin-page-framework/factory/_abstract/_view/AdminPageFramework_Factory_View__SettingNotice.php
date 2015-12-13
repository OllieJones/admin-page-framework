<?php
/**
 Admin Page Framework v3.7.3 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_Factory_View__SettingNotice extends AdminPageFramework_FrameworkUtility {
    public $oFactory;
    public function __construct($oFactory) {
        $this->oFactory = $oFactory;
        if (is_network_admin()) {
            add_action('network_admin_notices', array($this, '_replyToPrintSettingNotice'));
        } else {
            add_action('admin_notices', array($this, '_replyToPrintSettingNotice'));
        }
    }
    public function _replyToPrintSettingNotice() {
        if (!$this->_shouldProceed()) {
            return;
        }
        $this->oFactory->oForm->printSubmitNotices();
    }
    private function _shouldProceed() {
        if (!$this->oFactory->_isInThePage()) {
            return false;
        }
        if (self::$_bSettingNoticeLoaded) {
            return false;
        }
        self::$_bSettingNoticeLoaded = true;
        return true;
    }
    static private $_bSettingNoticeLoaded = false;
}