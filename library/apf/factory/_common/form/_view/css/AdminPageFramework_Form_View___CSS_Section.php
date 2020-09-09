<?php 
/**
	Admin Page Framework v3.8.22b06 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/admin-page-framework>
	Copyright (c) 2013-2020, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Form_View___CSS_Section extends AdminPageFramework_Form_View___CSS_Base {
    protected function _get() {
        return $this->_getFormSectionRules();
    }
    private function _getFormSectionRules() {
        $_sCSSRules = ".admin-page-framework-section .form-table {margin-top: 0;}.admin-page-framework-section .form-table td label { display: inline;}.admin-page-framework-section-tabs-contents {margin-top: 1em;}.admin-page-framework-section-tabs { margin: 0;}.admin-page-framework-tab-content { padding: 0.5em 2em 1.5em 2em;margin: 0;border-style: solid;border-width: 1px;border-color: #dfdfdf;background-color: #fdfdfd; }.admin-page-framework-section-tab {background-color: transparent;vertical-align: bottom; margin-bottom: -2px;margin-left: 0px;margin-right: 0.5em;background-color: #F1F1F1;font-weight: normal;}.admin-page-framework-section-tab:hover {background-color: #F8F8F8;}.admin-page-framework-section-tab.active {background-color: #fdfdfd; }.admin-page-framework-section-tab h4 {margin: 0;padding: 0.4em 0.8em;font-size: 1.12em;vertical-align: middle;white-space: nowrap;display:inline-block;font-weight: normal;}.admin-page-framework-section-tab.nav-tab {padding: 0.2em 0.4em;}.admin-page-framework-section-tab.nav-tab a {text-decoration: none;color: #464646;vertical-align: inherit; outline: 0; }.admin-page-framework-section-tab.nav-tab a:focus { box-shadow: none;}.admin-page-framework-section-tab.nav-tab.active a {color: #000;}.admin-page-framework-content ul.admin-page-framework-section-tabs > li.admin-page-framework-section-tab {list-style-type: none;margin: -4px 4px -1px 0;}.admin-page-framework-repeatable-section-buttons {float: right;clear: right;margin-top: 1em;}.admin-page-framework-repeatable-section-buttons.disabled > .repeatable-section-button {color: #edd;border-color: #edd;}.admin-page-framework-section-caption {text-align: left;margin: 0;}.admin-page-framework-section .admin-page-framework-section-title {}.admin-page-framework-sections.sortable-section > .admin-page-framework-section {padding: 1em 1.8em 1em 2.6em;}.admin-page-framework-sections.sortable-section > .admin-page-framework-section.is_subsection_collapsible {display: block; float: none;border: 0px;padding: 0;background: transparent;}.admin-page-framework-sections.sortable-section > .admin-page-framework-tab-content {display: block; float: none;border: 0px;padding: 0.5em 2em 1.5em 2em;margin: 0;border-style: solid;border-width: 1px;border-color: #dfdfdf;background-color: #fdfdfd;}.admin-page-framework-sections.sortable-section > .admin-page-framework-section {margin-bottom: 1em;}.admin-page-framework-section {margin-bottom: 1em; }.admin-page-framework-sectionset {margin-bottom: 1em; display:inline-block;width:100%;}.admin-page-framework-section > .admin-page-framework-sectionset {margin-left: 2em;}";
        $_sCSSRules.= $this->___getForWP47();
        $_sCSSRules.= $this->___getForWP53();
        return $_sCSSRules;
    }
    private function ___getForWP47() {
        if (version_compare($GLOBALS['wp_version'], '4.7', '<')) {
            return '';
        }
        return ".admin-page-framework-content ul.admin-page-framework-section-tabs > li.admin-page-framework-section-tab {margin-bottom: -2px;}";
    }
    private function ___getForWP53() {
        if (version_compare($GLOBALS['wp_version'], '5.3', '<')) {
            return '';
        }
        return ".repeatable-section-button.button.button-large {padding: 0;margin: 0;min-width: 2.48em;}.repeatable-section-button .dashicons {font-size: 1.32em;width: 100%;vertical-align: middle;}@media screen and (max-width: 782px) {.repeatable-section-button.button.button-large {min-width: 40px;}.repeatable-section-button .dashicons {height: 22px;}}";
    }
    }
    