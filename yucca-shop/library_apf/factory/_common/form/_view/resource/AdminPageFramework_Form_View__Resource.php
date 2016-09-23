<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_View__Resource extends yucca_shopAdminPageFramework_FrameworkUtility
{
    public $oForm;

    public function __construct($oForm)
    {
        $this->oForm = $oForm;
        if ($this->isDoingAjax()) {
            return;
        }
        if ($this->hasBeenCalled('resource_'.$oForm->aArguments['caller_id'])) {
            return;
        }
        $this->_setHooks();
    }

    private function _setHooks()
    {
        if (is_admin()) {
            $this->_setAdminHooks();

            return;
        }
        add_action('wp_enqueue_scripts', [$this, '_replyToEnqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, '_replyToEnqueueStyles']);
        add_action(did_action('wp_print_styles') ? 'wp_print_footer_scripts' : 'wp_print_styles', [$this, '_replyToAddStyle'], 999);
        add_action(did_action('wp_print_scripts') ? 'wp_print_footer_scripts' : 'wp_print_scripts', [$this, '_replyToAddScript'], 999);
        add_action('wp_footer', [$this, '_replyToEnqueueScripts']);
        add_action('wp_footer', [$this, '_replyToEnqueueStyles']);
        add_action('wp_print_footer_scripts', [$this, '_replyToAddStyle'], 999);
        add_action('wp_print_footer_scripts', [$this, '_replyToAddScript'], 999);
        new yucca_shopAdminPageFramework_Form_View__Resource__Head($this->oForm, 'wp_head');
    }

    private function _setAdminHooks()
    {
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
        new yucca_shopAdminPageFramework_Form_View__Resource__Head($this->oForm, 'admin_head');
    }

    public function _replyToEnqueueScripts()
    {
        if (!$this->oForm->isInThePage()) {
            return;
        }
        foreach ($this->oForm->getResources('src_scripts') as $_asEnqueue) {
            $this->_enqueueScript($_asEnqueue);
        }
    }

    private static $_aEnqueued = [];

    private function _enqueueScript($asEnqueue)
    {
        $_aEnqueueItem = $this->_getFormattedEnqueueScript($asEnqueue);
        if (isset(self::$_aEnqueued[$_aEnqueueItem['src']])) {
            return;
        }
        self::$_aEnqueued[$_aEnqueueItem['src']] = $_aEnqueueItem;
        wp_enqueue_script($_aEnqueueItem['handle_id'], $_aEnqueueItem['src'], $_aEnqueueItem['dependencies'], $_aEnqueueItem['version'], did_action('admin_body_class') ? true : $_aEnqueueItem['in_footer']);
        if ($_aEnqueueItem['translation']) {
            wp_localize_script($_aEnqueueItem['handle_id'], $_aEnqueueItem['handle_id'], $_aEnqueueItem['translation']);
        }
    }

    private function _getFormattedEnqueueScript($asEnqueue)
    {
        static $_iCallCount = 1;
        $_aEnqueueItem = $this->getAsArray($asEnqueue) + ['handle_id' => 'script_'.$this->oForm->aArguments['caller_id'].'_'.$_iCallCount, 'src' => null, 'dependencies' => null, 'version' => null, 'in_footer' => false, 'translation' => null];
        if (is_string($asEnqueue)) {
            $_aEnqueueItem['src'] = $asEnqueue;
        }
        $_aEnqueueItem['src'] = $this->getResolvedSRC($_aEnqueueItem['src']);
        $_iCallCount++;

        return $_aEnqueueItem;
    }

    public function _replyToEnqueueStyles()
    {
        if (!$this->oForm->isInThePage()) {
            return;
        }
        foreach ($this->oForm->getResources('src_styles') as $_asEnqueueItem) {
            $this->_enqueueStyle($_asEnqueueItem);
        }
    }

    private function _enqueueStyle($asEnqueue)
    {
        $_aEnqueueItem = $this->_getFormattedEnqueueStyle($asEnqueue);
        wp_enqueue_style($_aEnqueueItem['handle_id'], $_aEnqueueItem['src'], $_aEnqueueItem['dependencies'], $_aEnqueueItem['version'], $_aEnqueueItem['media']);
    }

    private function _getFormattedEnqueueStyle($asEnqueue)
    {
        static $_iCallCount = 1;
        $_aEnqueueItem = $this->getAsArray($asEnqueue) + ['handle_id' => 'style_'.$this->oForm->aArguments['caller_id'].'_'.$_iCallCount, 'src' => null, 'dependencies' => null, 'version' => null, 'media' => null];
        if (is_string($asEnqueue)) {
            $_aEnqueueItem['src'] = $asEnqueue;
        }
        $_aEnqueueItem['src'] = $this->getResolvedSRC($_aEnqueueItem['src']);
        $_iCallCount++;

        return $_aEnqueueItem;
    }

    public function _replyToAddStyle()
    {
        if (!$this->oForm->isInThePage()) {
            return;
        }
        $_sCSSRules = $this->_getFormattedInlineStyles($this->oForm->getResources('inline_styles'));
        $_sID = $this->sanitizeSlug(strtolower($this->oForm->aArguments['caller_id']));
        if ($_sCSSRules) {
            echo "<style type='text/css' id='inline-style-{$_sID}' class='yucca-shop-form-style'>".$_sCSSRules.'</style>';
        }
        $_sIECSSRules = $this->_getFormattedInlineStyles($this->oForm->getResources('inline_styles_ie'));
        if ($_sIECSSRules) {
            echo "<!--[if IE]><style type='text/css' id='inline-style-ie-{$_sID}' class='yucca-shop-form-ie-style'>".$_sIECSSRules.'</style><![endif]-->';
        }
        $this->oForm->setResources('inline_styles', []);
        $this->oForm->setResources('inline_styles_ie', []);
    }

    private function _getFormattedInlineStyles(array $aInlineStyles)
    {
        $_sCSSRules = implode(PHP_EOL, array_unique($aInlineStyles));

        return $_sCSSRules;
    }

    public function _replyToAddScript()
    {
        if (!$this->oForm->isInThePage()) {
            return;
        }
        $_sScript = implode(PHP_EOL, array_unique($this->oForm->getResources('inline_scripts')));
        if ($_sScript) {
            $_sID = $this->sanitizeSlug(strtolower($this->oForm->aArguments['caller_id']));
            echo "<script type='text/javascript' id='inline-script-{$_sID}' class='yucca-shop-form-script'>".'/* <![CDATA[ */'.$_sScript.'/* ]]> */'.'</script>';
        }
        $this->oForm->setResources('inline_scripts', []);
    }
}