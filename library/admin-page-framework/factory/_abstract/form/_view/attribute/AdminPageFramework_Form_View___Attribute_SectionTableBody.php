<?php
class AdminPageFramework_Form_View___Attribute_SectionTableBody extends AdminPageFramework_Form_View___Attribute_Base {
    public $sContext = 'section_table_content';
    protected function _getAttributes() {
        $_sCollapsibleType = $this->getElement($this->aArguments, array('collapsible', 'type'), 'box');
        return array('class' => $this->getAOrB($this->aArguments['_is_collapsible'], 'admin-page-framework-collapsible-section-content' . ' ' . 'admin-page-framework-collapsible-content' . ' ' . 'accordion-section-content' . ' ' . 'admin-page-framework-collapsible-content-type-' . $_sCollapsibleType, null),);
    }
}