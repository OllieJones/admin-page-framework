<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2021, Michael Uno; Licensed MIT
 *
 */

/**
 * Provides methods to retrieve post meta data for meta box form fields.
 *
 * @since       3.8.0
 * @package     AdminPageFramework/Factory/TermMeta
 * @internal
 * @extends     AdminPageFramework_Factory_Model___Meta_Base
 */
class AdminPageFramework_TermMeta_Model___TermMeta extends AdminPageFramework_Factory_Model___Meta_Base {

    /**
     * The callback function name or the callable object to retrieve meta data.
     */
    protected $osCallable   = 'get_term_meta';

}
