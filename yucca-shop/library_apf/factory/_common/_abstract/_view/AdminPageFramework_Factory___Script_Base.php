<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class yucca_shopAdminPageFramework_Factory___Script_Base extends yucca_shopAdminPageFramework_FrameworkUtility
{
    public $oMsg;

    public function __construct($oMsg = null)
    {
        if ($this->hasBeenCalled(get_class($this))) {
            return;
        }
        $this->oMsg = $oMsg ? $oMsg : yucca_shopAdminPageFramework_Message::getInstance();
        $this->registerAction('customize_controls_print_footer_scripts', [$this, '_replyToPrintScript']);
        $this->registerAction('admin_print_footer_scripts', [$this, '_replyToPrintScript']);
        $this->construct();
        add_action('wp_enqueue_scripts', [$this, 'load']);
    }

    public function construct()
    {
    }

    public function load()
    {
    }

    public function _replyToPrintScript()
    {
        $_sScript = $this->getScript($this->oMsg);
        if (!$_sScript) {
            return;
        }
        echo "<script type='text/javascript' class='".strtolower(get_class($this))."'>".'/* <![CDATA[ */'.$_sScript.'/* ]]> */'.'</script>';
    }

    public static function getScript()
    {
        $_aParams = func_get_args() + [null];
        $_oMsg = $_aParams[0];

        return '';
    }
}
