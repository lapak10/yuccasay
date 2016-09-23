<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_Model___DefaultValues extends yucca_shopAdminPageFramework_Form_Base
{
    public $aFieldsets = [];

    public function __construct()
    {
        $_aParameters = func_get_args() + [$this->aFieldsets];
        $this->aFieldsets = $_aParameters[0];
    }

    public function get()
    {
        $_aResult = $this->_getDefaultValues($this->aFieldsets, []);

        return $_aResult;
    }

    private function _getDefaultValues($aFieldsets, $aDefaultOptions)
    {
        foreach ($aFieldsets as $_sSectionPath => $_aItems) {
            $_aSectionPath = explode('|', $_sSectionPath);
            foreach ($_aItems as $_sFieldPath => $_aFieldset) {
                $_aFieldPath = explode('|', $_sFieldPath);
                $this->setMultiDimensionalArray($aDefaultOptions, '_default' === $_sSectionPath ? [$_sFieldPath] : array_merge($_aSectionPath, $_aFieldPath), $this->_getDefautValue($_aFieldset));
            }
        }

        return $aDefaultOptions;
    }

    private function _getDefautValue($aFieldset)
    {
        $_aSubFields = $this->getIntegerKeyElements($aFieldset);
        if (count($_aSubFields) == 0) {
            return $this->getElement($aFieldset, 'value', $this->getElement($aFieldset, 'default', null));
        }
        $_aDefault = [];
        array_unshift($_aSubFields, $aFieldset);
        foreach ($_aSubFields as $_iIndex => $_aField) {
            $_aDefault[$_iIndex] = $this->getElement($_aField, 'value', $this->getElement($_aField, 'default', null));
        }

        return $_aDefault;
    }
}
