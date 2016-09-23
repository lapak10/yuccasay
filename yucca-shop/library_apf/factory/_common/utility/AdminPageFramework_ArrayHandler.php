<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_FrameworkUtility extends yucca_shopAdminPageFramework_WPUtility
{
    public static function sortAdminSubMenu()
    {
        if (self::hasBeenCalled(__METHOD__)) {
            return;
        }
        foreach ((array) $GLOBALS['_apf_sub_menus_to_sort'] as $_sIndex => $_sMenuSlug) {
            if (!isset($GLOBALS['submenu'][$_sMenuSlug])) {
                continue;
            }
            ksort($GLOBALS['submenu'][$_sMenuSlug]);
            unset($GLOBALS['_apf_sub_menus_to_sort'][$_sIndex]);
        }
    }

    public static function getFrameworkVersion($bTrimDevVer = false)
    {
        $_sVersion = yucca_shopAdminPageFramework_Registry::getVersion();

        return $bTrimDevVer ? self::getSuffixRemoved($_sVersion, '.dev') : $_sVersion;
    }

    public static function getFrameworkName()
    {
        return yucca_shopAdminPageFramework_Registry::NAME;
    }
}
class yucca_shopAdminPageFramework_ArrayHandler extends yucca_shopAdminPageFramework_FrameworkUtility
{
    public $aData = [];
    public $aDefault = [];

    public function __construct()
    {
        $_aParameters = func_get_args() + [$this->aData, $this->aDefault];
        $this->aData = $_aParameters[0];
        $this->aDefault = $_aParameters[1];
    }

    public function get()
    {
        $_mDefault = null;
        $_aKeys = func_get_args() + [null];
        if (!isset($_aKeys[0])) {
            return $this->uniteArrays($this->aData, $this->aDefault);
        }
        if (is_array($_aKeys[0])) {
            $_aKeys = $_aKeys[0];
            $_mDefault = $this->getElement($_aKeys, 1);
        }

        return $this->getArrayValueByArrayKeys($this->aData, $_aKeys, $this->_getDefaultValue($_mDefault, $_aKeys));
    }

    private function _getDefaultValue($_mDefault, $_aKeys)
    {
        return isset($_mDefault) ? $_mDefault : $this->getArrayValueByArrayKeys($this->aDefault, $_aKeys);
    }

    public function set()
    {
        $_aParameters = func_get_args();
        if (!isset($_aParameters[0], $_aParameters[1])) {
            return;
        }
        $_asKeys = $_aParameters[0];
        $_mValue = $_aParameters[1];
        if (is_scalar($_asKeys)) {
            $this->aData[$_asKeys] = $_mValue;

            return;
        }
        $this->setMultiDimensionalArray($this->aData, $_asKeys, $_mValue);
    }

    public function delete()
    {
        $_aParameters = func_get_args();
        if (!isset($_aParameters[0], $_aParameters[1])) {
            return;
        }
        $_asKeys = $_aParameters[0];
        $_mValue = $_aParameters[1];
        if (is_scalar($_asKeys)) {
            $this->aData[$_asKeys] = $_mValue;

            return;
        }
        $this->unsetDimensionalArrayElement($this->aData, $aKeys);
    }

    public function __toString()
    {
        return $this->getObjectInfo($this);
    }
}
