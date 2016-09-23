<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class yucca_shopAdminPageFramework_Resource_Base extends yucca_shopAdminPageFramework_FrameworkUtility
{
    protected static $_aStructure_EnqueuingResources = ['sSRC' => null, 'aPostTypes' => [], 'sPageSlug' => null, 'sTabSlug' => null, 'sType' => null, 'handle_id' => null, 'dependencies' => [], 'version' => false, 'translation' => [], 'in_footer' => false, 'media' => 'all', 'attributes' => []];
    protected $_sClassSelector_Style = 'yucca-shop-style';
    protected $_sClassSelector_Script = 'yucca-shop-script';
    protected $_aHandleIDs = [];
    public $oProp;
    public $oUtil;

    public function __construct($oProp)
    {
        $this->oProp = $oProp;
        $this->oUtil = new yucca_shopAdminPageFramework_WPUtility();
        if ($this->isDoingAjax()) {
            return;
        }
        add_action('admin_enqueue_scripts', [$this, '_replyToEnqueueScripts']);
        add_action('admin_enqueue_scripts', [$this, '_replyToEnqueueStyles']);
        add_action(did_action('admin_print_styles') ? 'admin_print_footer_scripts' : 'admin_print_styles', [$this, '_replyToAddStyle'], 999);
        add_action(did_action('admin_print_scripts') ? 'admin_print_footer_scripts' : 'admin_print_scripts', [$this, '_replyToAddScript'], 999);
        add_action('customize_controls_print_footer_scripts', [$this, '_replyToEnqueueScripts']);
        add_action('customize_controls_print_footer_scripts', [$this, '_replyToEnqueueStyles']);
        add_action('admin_footer', [$this, '_replyToEnqueueScripts']);
        add_action('admin_footer', [$this, '_replyToEnqueueStyles']);
        add_action('admin_print_footer_scripts', [$this, '_replyToAddStyle'], 999);
        add_action('admin_print_footer_scripts', [$this, '_replyToAddScript'], 999);
        add_filter('script_loader_src', [$this, '_replyToSetupArgumentCallback'], 1, 2);
        add_filter('style_loader_src', [$this, '_replyToSetupArgumentCallback'], 1, 2);
    }

    public function _forceToEnqueueStyle($sSRC, $aCustomArgs = [])
    {
    }

    public function _forceToEnqueueScript($sSRC, $aCustomArgs = [])
    {
    }

    protected function _enqueueSRCByCondition($aEnqueueItem)
    {
        return $this->_enqueueSRC($aEnqueueItem);
    }

    public function _replyToSetupArgumentCallback($sSRC, $sHandleID)
    {
        if (isset($this->oProp->aResourceAttributes[$sHandleID])) {
            $this->_aHandleIDs[$sSRC] = $sHandleID;
            add_filter('clean_url', [$this, '_replyToModifyEnqueuedAttrbutes'], 1, 3);
            remove_filter(current_filter(), [$this, '_replyToSetupArgumentCallback'], 1, 2);
        }

        return $sSRC;
    }

    public function _replyToModifyEnqueuedAttrbutes($sSanitizedURL, $sOriginalURL, $sContext)
    {
        if ('display' !== $sContext) {
            return $sSanitizedURL;
        }
        if (isset($this->_aHandleIDs[$sOriginalURL])) {
            $_sHandleID = $this->_aHandleIDs[$sOriginalURL];
            $_aAttributes = $this->oProp->aResourceAttributes[$_sHandleID];
            if (empty($_aAttributes)) {
                return $sSanitizedURL;
            }
            $_sAttributes = $this->getAttributes($_aAttributes);
            $_sModifiedURL = $sSanitizedURL."' ".rtrim($_sAttributes, "'\"");

            return $_sModifiedURL;
        }

        return $sSanitizedURL;
    }

    private static $_bCommonStyleLoaded = false;

    protected function _printCommonStyles($sIDPrefix, $sClassName)
    {
        if (self::$_bCommonStyleLoaded) {
            return;
        }
        self::$_bCommonStyleLoaded = true;
        $_oCaller = $this->oProp->oCaller;
        echo $this->_getStyleTag($_oCaller, $sIDPrefix);
        echo $this->_getIEStyleTag($_oCaller, $sIDPrefix);
    }

    private function _getStyleTag($oCaller, $sIDPrefix)
    {
        $_sStyle = $this->addAndApplyFilters($oCaller, ['style_common_admin_page_framework', "style_common_{$this->oProp->sClassName}"], yucca_shopAdminPageFramework_CSS::getDefaultCSS());
        $_sStyle = trim($_sStyle);
        if ($_sStyle) {
            echo "<style type='text/css' id='".esc_attr($sIDPrefix)."'>".$_sStyle.'</style>';
        }
    }

    private function _getIEStyleTag($oCaller, $sIDPrefix)
    {
        $_sStyleIE = $this->addAndApplyFilters($oCaller, ['style_ie_common_admin_page_framework', "style_ie_common_{$this->oProp->sClassName}"], yucca_shopAdminPageFramework_CSS::getDefaultCSSIE());
        $_sStyleIE = trim($_sStyleIE);

        return $_sStyleIE ? "<!--[if IE]><style type='text/css' id='".esc_attr($sIDPrefix.'-ie')."'>".$_sStyleIE.'</style><![endif]-->' : '';
    }

    private static $_bCommonScriptLoaded = false;

    protected function _printCommonScripts($sIDPrefix, $sClassName)
    {
        if (self::$_bCommonScriptLoaded) {
            return;
        }
        self::$_bCommonScriptLoaded = true;
        $_sScript = $this->addAndApplyFilters($this->oProp->oCaller, ['script_common_admin_page_framework', "script_common_{$this->oProp->sClassName}"], yucca_shopAdminPageFramework_Property_Base::$_sDefaultScript);
        $_sScript = trim($_sScript);
        if ($_sScript) {
            echo "<script type='text/javascript' id='".esc_attr($sIDPrefix)."'>".'/* <![CDATA[ */'.$_sScript.'/* ]]> */'.'</script>';
        }
    }

    protected function _printClassSpecificStyles($sIDPrefix)
    {
        $_oCaller = $this->oProp->oCaller;
        echo $this->_getClassSpecificStyleTag($_oCaller, $sIDPrefix);
        echo $this->_getClassSpecificIEStyleTag($_oCaller, $sIDPrefix);
        $this->oProp->sStyle = '';
        $this->oProp->sStyleIE = '';
    }

    private function _getClassSpecificStyleTag($_oCaller, $sIDPrefix)
    {
        static $_iCallCount = 1;
        $_sStyle = $this->addAndApplyFilters($_oCaller, "style_{$this->oProp->sClassName}", $this->oProp->sStyle);
        $_sStyle = trim($_sStyle);
        if ($_sStyle) {
            $_iCallCount++;

            return "<style type='text/css' id='".esc_attr("{$sIDPrefix}-{$this->oProp->sClassName}_{$_iCallCount}")."'>".$_sStyle.'</style>';
        }

        return '';
    }

    private function _getClassSpecificIEStyleTag($_oCaller, $sIDPrefix)
    {
        static $_iCallCountIE = 1;
        $_sStyleIE = $this->addAndApplyFilters($_oCaller, "style_ie_{$this->oProp->sClassName}", $this->oProp->sStyleIE);
        $_sStyleIE = trim($_sStyleIE);
        if ($_sStyleIE) {
            $_iCallCountIE++;

            return "<!--[if IE]><style type='text/css' id='".esc_attr("{$sIDPrefix}-ie-{$this->oProp->sClassName}_{$_iCallCountIE}")."'>".$_sStyleIE.'</style><![endif]-->';
        }

        return '';
    }

    protected function _printClassSpecificScripts($sIDPrefix)
    {
        static $_iCallCount = 1;
        $_sScript = $this->addAndApplyFilters($this->oProp->oCaller, ["script_{$this->oProp->sClassName}"], $this->oProp->sScript);
        $_sScript = trim($_sScript);
        if ($_sScript) {
            $_iCallCount++;
            echo "<script type='text/javascript' id='".esc_attr("{$sIDPrefix}-{$this->oProp->sClassName}_{$_iCallCount}")."'>".'/* <![CDATA[ */'.$_sScript.'/* ]]> */'.'</script>';
        }
        $this->oProp->sScript = '';
    }

    public function _replyToAddStyle()
    {
        $_oCaller = $this->oProp->oCaller;
        if (!$_oCaller->_isInThePage()) {
            return;
        }
        $this->_printCommonStyles('yucca-shop-style-common', get_class());
        $this->_printClassSpecificStyles($this->_sClassSelector_Style.'-'.$this->oProp->sStructureType);
    }

    public function _replyToAddScript()
    {
        $_oCaller = $this->oProp->oCaller;
        if (!$_oCaller->_isInThePage()) {
            return;
        }
        $this->_printCommonScripts('yucca-shop-script-common', get_class());
        $this->_printClassSpecificScripts($this->_sClassSelector_Script.'-'.$this->oProp->sStructureType);
    }

    protected function _enqueueSRC($aEnqueueItem)
    {
        if ('style' === $aEnqueueItem['sType']) {
            wp_enqueue_style($aEnqueueItem['handle_id'], $aEnqueueItem['sSRC'], $aEnqueueItem['dependencies'], $aEnqueueItem['version'], $aEnqueueItem['media']);

            return;
        }
        wp_enqueue_script($aEnqueueItem['handle_id'], $aEnqueueItem['sSRC'], $aEnqueueItem['dependencies'], $aEnqueueItem['version'], did_action('admin_body_class') ? true : $aEnqueueItem['in_footer']);
        if ($aEnqueueItem['translation']) {
            wp_localize_script($aEnqueueItem['handle_id'], $aEnqueueItem['handle_id'], $aEnqueueItem['translation']);
        }
    }

    public function _replyToEnqueueStyles()
    {
        foreach ($this->oProp->aEnqueuingStyles as $_sKey => $_aEnqueuingStyle) {
            $this->_enqueueSRCByCondition($_aEnqueuingStyle);
            unset($this->oProp->aEnqueuingStyles[$_sKey]);
        }
    }

    public function _replyToEnqueueScripts()
    {
        foreach ($this->oProp->aEnqueuingScripts as $_sKey => $_aEnqueuingScript) {
            $this->_enqueueSRCByCondition($_aEnqueuingScript);
            unset($this->oProp->aEnqueuingScripts[$_sKey]);
        }
    }
}
