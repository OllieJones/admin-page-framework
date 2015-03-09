<?php
/**
 Admin Page Framework v3.5.6b01 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_WalkerTaxonomyChecklist extends Walker_Category {
    function start_el(&$sOutput, $oTerm, $iDepth = 0, $aArgs = array(), $iCurrentObjectID = 0) {
        $aArgs = $aArgs + array('name' => null, 'disabled' => null, 'selected' => array(), 'input_id' => null, 'attributes' => array(), 'taxonomy' => null,);
        $_iID = $oTerm->term_id;
        $_sTaxonomySlug = empty($aArgs['taxonomy']) ? 'category' : $aArgs['taxonomy'];
        $_sID = "{$aArgs['input_id']}_{$_sTaxonomySlug}_{$_iID}";
        $_sPostCount = $aArgs['show_post_count'] ? " <span class='font-lighter'>(" . $oTerm->count . ")</span>" : '';
        $_aInputAttributes = isset($_aInputAttributes[$_iID]) ? $_aInputAttributes[$_iID] + $aArgs['attributes'] : $aArgs['attributes'];
        $_aInputAttributes = array('id' => $_sID, 'value' => 1, 'type' => 'checkbox', 'name' => "{$aArgs['name']}[{$_iID}]", 'checked' => in_array($_iID, ( array )$aArgs['selected']) ? 'checked' : null,) + $_aInputAttributes;
        $_aInputAttributes['class'].= ' apf_checkbox';
        $_aLiTagAttributes = array('id' => "list-{$_sID}", 'class' => 'category-list', 'title' => $oTerm->description,);
        $sOutput.= "\n" . "<li " . AdminPageFramework_WPUtility::generateAttributes($_aLiTagAttributes) . ">" . "<label for='{$_sID}' class='taxonomy-checklist-label'>" . "<input value='0' type='hidden' name='{$aArgs['name']}[{$_iID}]' class='apf_checkbox' />" . "<input " . AdminPageFramework_WPUtility::generateAttributes($_aInputAttributes) . " />" . esc_html(apply_filters('the_category', $oTerm->name)) . $_sPostCount . "</label>";
    }
}