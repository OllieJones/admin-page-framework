<?php 
/**
	Admin Page Framework v3.9.0b07 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/admin-page-framework>
	Copyright (c) 2013-2021, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class AdminPageFramework_UserMeta extends AdminPageFramework_UserMeta_Controller {
    protected $_sStructureType = 'user_meta';
    public function __construct($sCapability = 'read', $sTextDomain = 'admin-page-framework') {
        $_sPropertyClassName = isset($this->aSubClassNames['oProp']) ? $this->aSubClassNames['oProp'] : 'AdminPageFramework_Property_' . $this->_sStructureType;
        $this->oProp = new $_sPropertyClassName($this, get_class($this), $sCapability, $sTextDomain, $this->_sStructureType);
        parent::__construct($this->oProp);
    }
    }
    