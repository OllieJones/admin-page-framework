<?php 
/**
	Admin Page Framework v3.8.22b06 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/admin-page-framework>
	Copyright (c) 2013-2020, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Form_term_meta extends AdminPageFramework_Form_Meta {
    public $sStructureType = 'term_meta';
    public function construct() {
        $this->_addDefaultResources();
    }
    private function _addDefaultResources() {
        $_oCSS = new AdminPageFramework_Form_View___CSS_term_meta;
        $this->addResource('internal_styles', $_oCSS->get());
    }
    public function get() {
        $_aArguments = func_get_args() + array(false);
        $bEditTerm = $_aArguments[0];
        $this->sCapability = $this->callback($this->aCallbacks['capability'], '');
        if (!$this->canUserView($this->sCapability)) {
            return '';
        }
        $this->_formatElementDefinitions($this->aSavedData);
        new AdminPageFramework_Form_View___Script_Form;
        $_oFormTables = new AdminPageFramework_Form_View___Sectionsets(array('capability' => $this->sCapability,) + $this->aArguments, array('field_type_definitions' => $this->aFieldTypeDefinitions, 'sectionsets' => $this->aSectionsets, 'fieldsets' => $this->aFieldsets,), $this->aSavedData, $this->getFieldErrors(), $this->aCallbacks, $this->oMsg);
        $_sAddNewTerm = $bEditTerm ? '' : ' add-new-term';
        $_sClassSelectors = 'admin-page-framework-form-table-term_meta' . $_sAddNewTerm;
        return '<tr class="admin-page-framework-form-table-outer-row-term_meta">' . '<td colspan=2>' . '<table class="' . $_sClassSelectors . '">' . '<tbody>' . '<tr>' . '<td>' . $_oFormTables->get() . '</td>' . '</tr>' . '</tbody>' . '</table>' . '</td>' . '</tr>';
    }
    }
    