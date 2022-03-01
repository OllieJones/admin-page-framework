<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2022, Michael Uno; Licensed MIT
 *
 */

/**
 * Collects data of page loads of the added network pages.
 *
 * @since       3.1.0
 * @extends     AdminPageFramework_PageLoadInfo_Base
 * @package     AdminPageFramework/Factory/NetworkAdmin/Debug
 * @internal
 */
class AdminPageFramework_PageLoadInfo_network_admin_page extends AdminPageFramework_PageLoadInfo_Base {

    private static $_oInstance;
    private static $aClassNames = array();

    public function __construct( $oProp, $oMsg ) {

        if ( is_network_admin() && $this->isDebugMode() ) {
            add_action(
                'in_admin_footer',
                array( $this, '_replyToSetPageLoadInfoInFooter' ),
                999 // must be loaded after the sub pages are registered
            );
        }
        parent::__construct( $oProp, $oMsg );

    }


    /**
     * Ensures that only one instance of this class object exists per class. ( no multiple instances of this object on a particular class )
     *
     * @remark This class should be instantiated via this method.
     */
    public static function instantiate( $oProp, $oMsg ) {

        if ( ! is_network_admin() ) {
            return;
        }

        if ( in_array( $oProp->sClassName, self::$aClassNames ) ) {
            return self::$_oInstance;
        }

        self::$aClassNames[] = $oProp->sClassName;
        self::$_oInstance = new AdminPageFramework_PageLoadInfo_network_admin_page( $oProp, $oMsg );

        return self::$_oInstance;

    }

    /**
     * Sets the hook if the current page is one of the framework's added pages.
     * @internal
     */
    public function _replyToSetPageLoadInfoInFooter() {

        // For added pages
        if ( $this->oProp->isPageAdded() ) {
            add_filter( 'update_footer', array( $this, '_replyToGetPageLoadInfo' ), 999 );
        }

    }

}
