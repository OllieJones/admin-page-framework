<?php
/**
 * Admin Page Framework
 * 
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2022, Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides base methods that deal with generating values.
 * 
 * @package     AdminPageFramework/Common/Form/View/Generator
 * @since       3.6.0
 * @internal
 * @extends     AdminPageFramework_FrameworkUtility
 */
abstract class AdminPageFramework_Form_View___Generate_Base extends AdminPageFramework_FrameworkUtility {
    
    public $aArguments = array();
    
    /**
     * Sets up properties.
     */
    public function __construct( /* $aArguments */ ) {
        
        $_aParameters     = func_get_args() + array( 
            $this->aArguments, 
        );
        $this->aArguments = $_aParameters[ 0 ];                
        
    }
    
    /**
     * 
     * @return      string       The generated string value.
     */
    public function get() {
        return '';
    }
           
}
