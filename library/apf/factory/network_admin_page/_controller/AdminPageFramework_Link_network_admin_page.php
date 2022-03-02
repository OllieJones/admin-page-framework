<?php
/*
 * Admin Page Framework v3.9.1b01 by Michael Uno
 * Compiled with Admin Page Framework Compiler <https://github.com/michaeluno/admin-page-framework-compiler>
 * <https://en.michaeluno.jp/admin-page-framework>
 * Copyright (c) 2013-2022, Michael Uno; Licensed under MIT <https://opensource.org/licenses/MIT>
 */

class AdminPageFramework_Link_network_admin_page extends AdminPageFramework_Link_admin_page {
    public function __construct($oProp, $oMsg=null)
    {
        parent::__construct($oProp, $oMsg);
        if ($this->_shouldSetPluginActionLinks()) {
            remove_filter('plugin_action_links_' . plugin_basename($this->oProp->aScriptInfo['sPath']), array( $this, '_replyToAddSettingsLinkInPluginListingPage' ), 20);
            add_filter('network_admin_plugin_action_links_' . plugin_basename($this->oProp->aScriptInfo['sPath']), array( $this, '_replyToAddSettingsLinkInPluginListingPage' ));
        }
    }
    protected $_sFilterSuffix_PluginActionLinks = 'network_admin_plugin_action_links_';
}
