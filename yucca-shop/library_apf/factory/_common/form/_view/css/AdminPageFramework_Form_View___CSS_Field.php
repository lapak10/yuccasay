<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_View___CSS_Field extends yucca_shopAdminPageFramework_Form_View___CSS_Base
{
    protected function _get()
    {
        return $this->_getFormFieldRules();
    }

    private static function _getFormFieldRules()
    {
        return "td.yucca-shop-field-td-no-title {padding-left: 0;padding-right: 0;}.yucca-shop-fields {display: table; width: 100%;table-layout: fixed;}.yucca-shop-field input[type='number'] {text-align: right;} .yucca-shop-fields .disabled,.yucca-shop-fields .disabled input,.yucca-shop-fields .disabled textarea,.yucca-shop-fields .disabled select,.yucca-shop-fields .disabled option {color: #BBB;}.yucca-shop-fields hr {border: 0; height: 0;border-top: 1px solid #dfdfdf; }.yucca-shop-fields .delimiter {display: inline;}.yucca-shop-fields-description {margin-bottom: 0;}.yucca-shop-field {float: left;clear: both;display: inline-block;margin: 1px 0;}.yucca-shop-field label{display: inline-block; width: 100%;}.yucca-shop-field .yucca-shop-input-label-container {margin-bottom: 0.25em;}@media only screen and ( max-width: 780px ) { .yucca-shop-field .yucca-shop-input-label-container {margin-bottom: 0.5em;}} .yucca-shop-field .yucca-shop-input-label-string {padding-right: 1em; vertical-align: middle; display: inline-block; }.yucca-shop-field .yucca-shop-input-button-container {padding-right: 1em; }.yucca-shop-field .yucca-shop-input-container {display: inline-block;vertical-align: middle;}.yucca-shop-field-image .yucca-shop-input-label-container { vertical-align: middle;}.yucca-shop-field .yucca-shop-input-label-container {display: inline-block; vertical-align: middle; } .repeatable .yucca-shop-field {clear: both;display: block;}.yucca-shop-repeatable-field-buttons {float: right; margin: 0.1em 0 0.5em 0.3em;vertical-align: middle;}.yucca-shop-repeatable-field-buttons .repeatable-field-button {margin: 0 0.1em;font-weight: normal;vertical-align: middle;text-align: center;}@media only screen and (max-width: 960px) {.yucca-shop-repeatable-field-buttons {margin-top: 0;}}.yucca-shop-sections.sortable-section > .yucca-shop-section,.sortable .yucca-shop-field {clear: both;float: left;display: inline-block;padding: 1em 1.32em 1em;margin: 1px 0 0 0;border-top-width: 1px;border-bottom-width: 1px;border-bottom-style: solid;-webkit-user-select: none;-moz-user-select: none;user-select: none; text-shadow: #fff 0 1px 0;-webkit-box-shadow: 0 1px 0 #fff;box-shadow: 0 1px 0 #fff;-webkit-box-shadow: inset 0 1px 0 #fff;box-shadow: inset 0 1px 0 #fff;-webkit-border-radius: 3px;border-radius: 3px;background: #f1f1f1;background-image: -webkit-gradient(linear, left bottom, left top, from(#ececec), to(#f9f9f9));background-image: -webkit-linear-gradient(bottom, #ececec, #f9f9f9);background-image: -moz-linear-gradient(bottom, #ececec, #f9f9f9);background-image: -o-linear-gradient(bottom, #ececec, #f9f9f9);background-image: linear-gradient(to top, #ececec, #f9f9f9);border: 1px solid #CCC;background: #F6F6F6;} .yucca-shop-fields.sortable {margin-bottom: 1.2em; } .yucca-shop-field .button.button-small {width: auto;} .font-lighter {font-weight: lighter;} .yucca-shop-field .button.button-small.dashicons {font-size: 1.2em;padding-left: 0.2em;padding-right: 0.22em;}";
    }

    protected function _getVersionSpecific()
    {
        $_sCSSRules = '';
        if (version_compare($GLOBALS['wp_version'], '3.8', '<')) {
            $_sCSSRules .= '.yucca-shop-field .remove_value.button.button-small {line-height: 1.5em; }';
        }
        if (version_compare($GLOBALS['wp_version'], '3.8', '>=')) {
            $_sCSSRules .= '.yucca-shop-repeatable-field-buttons {margin: 2px 0 0 0.3em;} @media screen and ( max-width: 782px ) {.yucca-shop-fieldset {overflow-x: hidden;}}';
        }

        return $_sCSSRules;
    }
}
