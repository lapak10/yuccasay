<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_View___Section_Base extends yucca_shopAdminPageFramework_Form_Base
{
    public function isSectionsetVisible($aSectionset)
    {
        if (empty($aSectionset)) {
            return false;
        }

        return $this->callBack($this->aCallbacks['is_sectionset_visible'], [true, $aSectionset]);
    }

    public function isFieldsetVisible($aFieldset)
    {
        if (empty($aFieldset)) {
            return false;
        }

        return $this->callBack($this->aCallbacks['is_fieldset_visible'], [true, $aFieldset]);
    }

    public function getFieldsetOutput($aFieldset)
    {
        if (!$this->isFieldsetVisible($aFieldset)) {
            return '';
        }
        $_oFieldset = new yucca_shopAdminPageFramework_Form_View___Fieldset($aFieldset, $this->aSavedData, $this->aFieldErrors, $this->aFieldTypeDefinitions, $this->oMsg, $this->aCallbacks);
        $_sFieldOutput = $_oFieldset->get();

        return $_sFieldOutput;
    }
}
class yucca_shopAdminPageFramework_Form_View___SectionTitle extends yucca_shopAdminPageFramework_Form_View___Section_Base
{
    public $aArguments = ['title' => null, 'tag' => null, 'section_index' => null, 'sectionset' => []];
    public $aFieldsets = [];
    public $aSavedData = [];
    public $aFieldErrors = [];
    public $aFieldTypeDefinitions = [];
    public $oMsg;
    public $aCallbacks = ['fieldset_output', 'is_fieldset_visible' => null];

    public function __construct()
    {
        $_aParameters = func_get_args() + [$this->aArguments, $this->aFieldsets, $this->aSavedData, $this->aFieldErrors, $this->aFieldTypeDefinitions, $this->oMsg, $this->aCallbacks];
        $this->aArguments = $_aParameters[0] + $this->aArguments;
        $this->aFieldsets = $_aParameters[1];
        $this->aSavedData = $_aParameters[2];
        $this->aFieldErrors = $_aParameters[3];
        $this->aFieldTypeDefinitions = $_aParameters[4];
        $this->oMsg = $_aParameters[5];
        $this->aCallbacks = $_aParameters[6];
    }

    public function get()
    {
        $_sTitle = $this->_getSectionTitle($this->aArguments['title'], $this->aArguments['tag'], $this->aFieldsets, $this->aArguments['section_index'], $this->aFieldTypeDefinitions);

        return $_sTitle;
    }

    private function _getToolTip()
    {
        $_aSectionset = $this->aArguments['sectionset'];
        $_sSectionTitleTagID = str_replace('|', '_', $_aSectionset['_section_path']).'_'.$this->aArguments['section_index'];
        $_oToolTip = new yucca_shopAdminPageFramework_Form_View___ToolTip($_aSectionset['tip'], $_sSectionTitleTagID);

        return $_oToolTip->get();
    }

    protected function _getSectionTitle($sTitle, $sTag, $aFieldsets, $iSectionIndex = null, $aFieldTypeDefinitions = [], $aCollapsible = [])
    {
        $_aSectionTitleField = $this->_getSectionTitleField($aFieldsets, $iSectionIndex, $aFieldTypeDefinitions);

        return $_aSectionTitleField ? $this->getFieldsetOutput($_aSectionTitleField) : "<{$sTag}>".$this->_getCollapseButton($aCollapsible).$sTitle.$this->_getToolTip()."</{$sTag}>";
    }

    private function _getCollapseButton($aCollapsible)
    {
        $_sExpand = esc_attr($this->oMsg->get('click_to_expand'));
        $_sCollapse = esc_attr($this->oMsg->get('click_to_collapse'));

        return $this->getAOrB('button' === $this->getElement($aCollapsible, 'type', 'box'), "<span class='yucca-shop-collapsible-button yucca-shop-collapsible-button-expand' title='{$_sExpand}'>&#9658;</span>"."<span class='yucca-shop-collapsible-button yucca-shop-collapsible-button-collapse' title='{$_sCollapse}'>&#9660;</span>", '');
    }

    private function _getSectionTitleField(array $aFieldsetsets, $iSectionIndex, $aFieldTypeDefinitions)
    {
        foreach ($aFieldsetsets as $_aFieldsetset) {
            if ('section_title' !== $_aFieldsetset['type']) {
                continue;
            }
            $_oFieldsetOutputFormatter = new yucca_shopAdminPageFramework_Form_Model___Format_FieldsetOutput($_aFieldsetset, $iSectionIndex, $aFieldTypeDefinitions);

            return $_oFieldsetOutputFormatter->get();
        }
    }
}
class yucca_shopAdminPageFramework_Form_View___CollapsibleSectionTitle extends yucca_shopAdminPageFramework_Form_View___SectionTitle
{
    public $aArguments = ['title' => null, 'tag' => null, 'section_index' => null, 'collapsible' => [], 'container_type' => 'section', 'sectionset' => []];
    public $aFieldsets = [];
    public $aSavedData = [];
    public $aFieldErrors = [];
    public $aFieldTypeDefinitions = [];
    public $oMsg;
    public $aCallbacks = ['fieldset_output', 'is_fieldset_visible' => null];

    public function get()
    {
        if (empty($this->aArguments['collapsible'])) {
            return '';
        }

        return $this->_getCollapsibleSectionTitleBlock($this->aArguments['collapsible'], $this->aArguments['container_type'], $this->aArguments['section_index']);
    }

    private function _getCollapsibleSectionTitleBlock(array $aCollapsible, $sContainer = 'sections', $iSectionIndex = null)
    {
        if ($sContainer !== $aCollapsible['container']) {
            return '';
        }
        $_sSectionTitle = $this->_getSectionTitle($this->aArguments['title'], $this->aArguments['tag'], $this->aFieldsets, $iSectionIndex, $this->aFieldTypeDefinitions, $aCollapsible);
        $_aSectionset = $this->aArguments['sectionset'];
        $_sSectionTitleTagID = str_replace('|', '_', $_aSectionset['_section_path']).'_'.$iSectionIndex;

        return $this->_getCollapsibleSectionsEnablerScript().'<div '.$this->getAttributes(['id' => $_sSectionTitleTagID, 'class' => $this->getClassAttribute('yucca-shop-section-title', $this->getAOrB('box' === $aCollapsible['type'], 'accordion-section-title', ''), 'yucca-shop-collapsible-title', $this->getAOrB('sections' === $aCollapsible['container'], 'yucca-shop-collapsible-sections-title', 'yucca-shop-collapsible-section-title'), $this->getAOrB($aCollapsible['is_collapsed'], 'collapsed', ''), 'yucca-shop-collapsible-type-'.$aCollapsible['type'])] + $this->getDataAttributeArray($aCollapsible)).'>'.$_sSectionTitle.'</div>';
    }

    private static $_bLoaded = false;

    protected function _getCollapsibleSectionsEnablerScript()
    {
        if (self::$_bLoaded) {
            return;
        }
        self::$_bLoaded = true;
        new yucca_shopAdminPageFramework_Form_View___Script_CollapsibleSection($this->oMsg);
    }
}
