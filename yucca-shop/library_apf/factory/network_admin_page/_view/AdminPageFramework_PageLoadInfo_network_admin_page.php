<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_PageLoadInfo_network_admin_page extends yucca_shopAdminPageFramework_PageLoadInfo_Base
{
    private static $_oInstance;
    private static $aClassNames = [];

    public function __construct($oProp, $oMsg)
    {
        if (is_network_admin() && defined('WP_DEBUG') && WP_DEBUG) {
            add_action('in_admin_footer', [$this, '_replyToSetPageLoadInfoInFooter'], 999);
        }
        parent::__construct($oProp, $oMsg);
    }

    public static function instantiate($oProp, $oMsg)
    {
        if (!is_network_admin()) {
            return;
        }
        if (in_array($oProp->sClassName, self::$aClassNames)) {
            return self::$_oInstance;
        }
        self::$aClassNames[] = $oProp->sClassName;
        self::$_oInstance = new self($oProp, $oMsg);

        return self::$_oInstance;
    }

    public function _replyToSetPageLoadInfoInFooter()
    {
        if ($this->oProp->isPageAdded()) {
            add_filter('update_footer', [$this, '_replyToGetPageLoadInfo'], 999);
        }
    }
}
