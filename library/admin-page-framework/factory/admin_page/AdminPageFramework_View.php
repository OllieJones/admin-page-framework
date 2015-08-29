<?php
abstract class AdminPageFramework_View extends AdminPageFramework_Model {
    public function _replyToPrintAdminNotices() {
        if (!$this->_isInThePage()) {
            return;
        }
        foreach ($this->oProp->aAdminNotices as $_aAdminNotice) {
            $_sClassSelectors = $this->oUtil->generateClassAttribute($this->oUtil->getElement($_aAdminNotice, array('sClassSelector'), ''), 'notice is-dismissible');
            echo "<div class='{$_sClassSelectors}' id='{$_aAdminNotice['sID']}'>" . "<p>" . $_aAdminNotice['sMessage'] . "</p>" . "</div>";
        }
    }
    public function content($sContent) {
        return $sContent;
    }
}