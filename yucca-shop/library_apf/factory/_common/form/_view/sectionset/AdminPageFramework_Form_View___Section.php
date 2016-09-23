<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_View___Section extends yucca_shopAdminPageFramework_FrameworkUtility
{
    public $aArguments = [];
    public $aSectionset = [];
    public $aStructure = [];
    public $aFieldsetsPerSection = [];
    public $aSavedData = [];
    public $aFieldErrors = [];
    public $aFieldTypeDefinitions = [];
    public $aCallbacks = [];
    public $oMsg;

    public function __construct()
    {
        $_aParameters = func_get_args() + [$this->aArguments, $this->aSectionset, $this->aStructure, $this->aFieldsetsPerSection, $this->aSavedData, $this->aFieldErrors, $this->aFieldTypeDefinitions, $this->aCallbacks, $this->oMsg];
        $this->aArguments = $this->getAsArray($_aParameters[0]);
        $this->aSectionset = $this->getAsArray($_aParameters[1]);
        $this->aStructure = $this->getAsArray($_aParameters[2]);
        $this->aFieldsetsPerSection = $this->getAsArray($_aParameters[3]);
        $this->aSavedData = $this->getAsArray($_aParameters[4]);
        $this->aFieldErrors = $this->getAsArray($_aParameters[5]);
        $this->aFieldTypeDefinitions = $this->getAsArray($_aParameters[6]);
        $this->aCallbacks = $this->getAsArray($_aParameters[7]) + $this->aCallbacks;
        $this->oMsg = $_aParameters[8];
    }

    public function get()
    {
        $_iSectionIndex = $this->aSectionset['_index'];
        $_oTableCaption = new yucca_shopAdminPageFramework_Form_View___SectionCaption($this->aSectionset, $_iSectionIndex, $this->aFieldsetsPerSection, $this->aSavedData, $this->aFieldErrors, $this->aFieldTypeDefinitions, $this->aCallbacks, $this->oMsg);
        $_oSectionTableAttributes = new yucca_shopAdminPageFramework_Form_View___Attribute_SectionTable($this->aSectionset);
        $_oSectionTableBodyAttributes = new yucca_shopAdminPageFramework_Form_View___Attribute_SectionTableBody($this->aSectionset);
        $_aOutput = [];
        $_aOutput[] = '<table '.$_oSectionTableAttributes->get().'>'.$_oTableCaption->get().'<tbody '.$_oSectionTableBodyAttributes->get().'>'.$this->_getSectionContent($_iSectionIndex).'</tbody>'.'</table>';
        $_oSectionTableContainerAttributes = new yucca_shopAdminPageFramework_Form_View___Attribute_SectionTableContainer($this->aSectionset);

        return '<div '.$_oSectionTableContainerAttributes->get().'>'.implode(PHP_EOL, $_aOutput).'</div>';
    }

    private function _getSectionContent($_iSectionIndex)
    {
        if ($this->aSectionset['content']) {
            return $this->_getCustomSectionContent();
        }
        $_oFieldsets = new yucca_shopAdminPageFramework_Form_View___FieldsetRows($this->aFieldsetsPerSection, $_iSectionIndex, $this->aSavedData, $this->aFieldErrors, $this->aFieldTypeDefinitions, $this->aCallbacks, $this->oMsg);

        return $_oFieldsets->get();
    }

    private function _getCustomSectionContent()
    {
        if (is_scalar($this->aSectionset['content'])) {
            return "<tr class='yucca-shop-custom-content'>".'<td>'.$this->aSectionset['content'].'</td>'.'</tr>';
        }
        $_sSectionPath = $this->aSectionset['_section_path'];
        $_aSectionsets = $this->aStructure['sectionsets'];
        if (!isset($_aSectionsets[$_sSectionPath])) {
            return '';
        }
        unset($_aSectionsets[$_sSectionPath]);
        $_aNestedSectionPaths = $this->_getNestedSectionPaths($_sSectionPath, $this->aSectionset['content'], $_aSectionsets);
        $_aSectionsets = array_intersect_key($_aSectionsets, $_aNestedSectionPaths);
        $_aStructure = $this->aStructure;
        $_aStructure['sectionsets'] = $_aSectionsets;
        $_aArguments = ['nested_depth' => $this->getElement($this->aArguments, 'nested_depth', 0) + 1] + $this->aArguments;
        $_oFormTables = new yucca_shopAdminPageFramework_Form_View___Sectionsets($_aArguments, $_aStructure, $this->aSavedData, $this->aFieldErrors, $this->aCallbacks, $this->oMsg);

        return "<tr class='yucca-shop-nested-sectionsets'>".'<td>'.$_oFormTables->get().'</td>'.'</tr>';
    }

    private function _getNestedSectionPaths($sSubjectSectionPath, array $aNestedSctionsets, array $aSectionsets)
    {
        $_aNestedSectionPaths = [];
        foreach ($aNestedSctionsets as $_aNestedSectionset) {
            if (!is_array($_aNestedSectionset)) {
                continue;
            }
            $_sThisSectionPath = $sSubjectSectionPath.'|'.$_aNestedSectionset['section_id'];
            $_aNestedSectionPaths[$_sThisSectionPath] = $_sThisSectionPath;
        }
        $_aChildSectionPaths = [];
        foreach ($_aNestedSectionPaths as $_sNestedSectionPath) {
            $_aNestedSectionsets = $this->getElementAsArray($aSectionsets, [$_sNestedSectionPath, 'content']);
            $_aChildSectionPaths = $_aChildSectionPaths + $this->_getNestedSectionPaths($_sNestedSectionPath, $_aNestedSectionsets, $aSectionsets);
        }

        return $_aNestedSectionPaths + $_aChildSectionPaths;
    }
}
