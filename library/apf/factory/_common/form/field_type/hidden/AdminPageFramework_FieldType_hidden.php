<?php 
/**
	Admin Page Framework v3.9.0b13 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<https://en.michaeluno.jp/admin-page-framework>
	Copyright (c) 2013-2021, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_FieldType_hidden extends AdminPageFramework_FieldType {
    public $aFieldTypeSlugs = array('hidden');
    protected $aDefaultKeys = array();
    protected function getField($aField) {
        return $aField['before_label'] . "<div class='admin-page-framework-input-label-container'>" . "<label for='{$aField['input_id']}'>" . $aField['before_input'] . ($aField['label'] ? "<span " . $this->getLabelContainerAttributes($aField, 'admin-page-framework-input-label-string') . ">" . $aField['label'] . "</span>" : "") . "<input " . $this->getAttributes($aField['attributes']) . " />" . $aField['after_input'] . "</label>" . "</div>" . $aField['after_label'];
    }
    }
    