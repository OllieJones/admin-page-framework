<?php 
/**
	Admin Page Framework v3.9.0b09 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/admin-page-framework>
	Copyright (c) 2013-2021, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class AdminPageFramework_Utility_HTMLAttribute extends AdminPageFramework_Utility_SystemInformation {
    static public function getAttributes(array $aAttributes) {
        $_sQuoteCharactor = "'";
        $_aOutput = array();
        foreach ($aAttributes as $sAttribute => $sProperty) {
            if (!is_scalar($sProperty)) {
                continue;
            }
            $_aOutput[] = "{$sAttribute}={$_sQuoteCharactor}{$sProperty}{$_sQuoteCharactor}";
        }
        return implode(' ', $_aOutput);
    }
    static public function getInlineCSS(array $aCSSRules) {
        $_aOutput = array();
        foreach ($aCSSRules as $_sProperty => $_sValue) {
            if (is_null($_sValue)) {
                continue;
            }
            $_aOutput[] = $_sProperty . ': ' . $_sValue;
        }
        return implode('; ', $_aOutput);
    }
    static public function generateInlineCSS(array $aCSSRules) {
        return self::getInlineCSS($aCSSRules);
    }
    static public function getStyleAttribute($asInlineCSSes) {
        $_aCSSRules = array();
        foreach (array_reverse(func_get_args()) as $_asCSSRules) {
            if (is_array($_asCSSRules)) {
                $_aCSSRules = array_merge($_asCSSRules, $_aCSSRules);
                continue;
            }
            $__aCSSRules = explode(';', $_asCSSRules);
            foreach ($__aCSSRules as $_sPair) {
                $_aCSSPair = explode(':', $_sPair);
                if (!isset($_aCSSPair[0], $_aCSSPair[1])) {
                    continue;
                }
                $_aCSSRules[$_aCSSPair[0]] = $_aCSSPair[1];
            }
        }
        return self::getInlineCSS(array_unique($_aCSSRules));
    }
    static public function generateStyleAttribute($asInlineCSSes) {
        self::getStyleAttribute($asInlineCSSes);
    }
    static public function getClassAttribute() {
        $_aClasses = array();
        foreach (func_get_args() as $_asClasses) {
            if (!in_array(gettype($_asClasses), array('array', 'string'))) {
                continue;
            }
            $_aClasses = array_merge($_aClasses, is_array($_asClasses) ? $_asClasses : explode(' ', $_asClasses));
        }
        $_aClasses = array_unique(array_filter($_aClasses));
        return trim(implode(' ', $_aClasses));
    }
    static public function generateClassAttribute() {
        $_aParams = func_get_args();
        return call_user_func_array(array(__CLASS__, 'getClassAttribute'), $_aParams);
    }
    static public function getDataAttributeArray(array $aArray) {
        $_aNewArray = array();
        foreach ($aArray as $sKey => $v) {
            if (in_array(gettype($v), array('object', 'NULL'))) {
                continue;
            }
            if (is_array($v)) {
                $v = json_encode($v);
            }
            $_sKey = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $sKey));
            if ('' === $v) {
                $_aNewArray["data-{$_sKey}"] = '';
                continue;
            }
            $_aNewArray["data-{$_sKey}"] = $v ? $v : '0';
        }
        return $_aNewArray;
    }
    }
    