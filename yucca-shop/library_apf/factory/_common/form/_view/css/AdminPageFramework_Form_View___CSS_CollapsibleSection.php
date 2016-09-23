<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_View___CSS_Base extends yucca_shopAdminPageFramework_FrameworkUtility
{
    public $aAdded = [];

    public function add($sCSSRules)
    {
        $this->aAdded[] = $sCSSRules;
    }

    public function get()
    {
        $_sCSSRules = $this->_get().PHP_EOL;
        $_sCSSRules .= $this->_getVersionSpecific();
        $_sCSSRules .= implode(PHP_EOL, $this->aAdded);

        return $_sCSSRules;
    }

    protected function _get()
    {
        return '';
    }

    protected function _getVersionSpecific()
    {
        return '';
    }
}
class yucca_shopAdminPageFramework_Form_View___CSS_CollapsibleSection extends yucca_shopAdminPageFramework_Form_View___CSS_Base
{
    protected function _get()
    {
        return $this->_getCollapsibleSectionsRules();
    }

    private function _getCollapsibleSectionsRules()
    {
        $_sCSSRules = ".yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box, .yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box{font-size:13px;background-color: #fff;padding: 15px 18px;margin-top: 1em; border-top: 1px solid #eee;border-bottom: 1px solid #eee;}.yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box.collapsed.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.collapsed {border-bottom: 1px solid #dfdfdf;margin-bottom: 1em; }.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box {margin-top: 0;}.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.collapsed {margin-bottom: 0;}#poststuff .metabox-holder .yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box.yucca-shop-section-title h3,#poststuff .metabox-holder .yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.yucca-shop-section-title h3{font-size: 1em;margin: 0;}.yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box.accordion-section-title:after,.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.accordion-section-title:after {top: 12px;right: 15px;}.yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box.accordion-section-title:after,.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.accordion-section-title:after {content: '\\f142';}.yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box.accordion-section-title.collapsed:after,.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.accordion-section-title.collapsed:after {content: '\\f140';} .yucca-shop-collapsible-sections-content.yucca-shop-collapsible-content.accordion-section-content,.yucca-shop-collapsible-section-content.yucca-shop-collapsible-content.accordion-section-content,.yucca-shop-collapsible-sections-content.yucca-shop-collapsible-content-type-box, .yucca-shop-collapsible-section-content.yucca-shop-collapsible-content-type-box{border: 1px solid #dfdfdf;border-top: 0;background-color: #fff;}tbody.yucca-shop-collapsible-content {display: table-caption; padding: 10px 20px 15px 20px;}tbody.yucca-shop-collapsible-content.table-caption {display: table-caption; }.yucca-shop-collapsible-toggle-all-button-container {margin-top: 1em;margin-bottom: 1em;width: 100%;display: table; }.yucca-shop-collapsible-toggle-all-button.button {height: 36px;line-height: 34px;padding: 0 16px 6px;font-size: 20px;width: auto;}.flipped > .yucca-shop-collapsible-toggle-all-button.button.dashicons {-moz-transform: scaleY(-1);-webkit-transform: scaleY(-1);transform: scaleY(-1);filter: flipv; }.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box .yucca-shop-repeatable-section-buttons {margin: 0;margin-right: 2em; margin-top: -0.32em;}.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box .yucca-shop-repeatable-section-buttons.section_title_field_sibling {margin-top: 0;}.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box .repeatable-section-button {background: none; }.accordion-section-content.yucca-shop-collapsible-content-type-button {background-color: transparent;}.yucca-shop-collapsible-button {color: #888;margin-right: 0.4em;font-size: 0.8em;}.yucca-shop-collapsible-button-collapse {display: inline;} .collapsed > * > .yucca-shop-collapsible-button-collapse {display: none;}.yucca-shop-collapsible-button-expand {display: none;}.collapsed > * > .yucca-shop-collapsible-button-expand {display: inline;}";
        if (version_compare($GLOBALS['wp_version'], '3.8', '<')) {
            $_sCSSRules .= ".yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box.accordion-section-title:after,.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.accordion-section-title:after {content: '';top: 18px;}.yucca-shop-collapsible-sections-title.yucca-shop-collapsible-type-box.accordion-section-title.collapsed:after,.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box.accordion-section-title.collapsed:after {content: '';} .yucca-shop-collapsible-toggle-all-button.button {font-size: 1em;}.yucca-shop-collapsible-section-title.yucca-shop-collapsible-type-box .yucca-shop-repeatable-section-buttons {top: -8px;}";
        }

        return $_sCSSRules;
    }
}
