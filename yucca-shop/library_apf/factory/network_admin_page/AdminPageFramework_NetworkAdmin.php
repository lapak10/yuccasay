<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class yucca_shopAdminPageFramework_NetworkAdmin extends yucca_shopAdminPageFramework
{
    protected $_aBuiltInRootMenuSlugs = ['dashboard' => 'index.php', 'sites' => 'sites.php', 'themes' => 'themes.php', 'plugins' => 'plugins.php', 'users' => 'users.php', 'settings' => 'settings.php', 'updates' => 'update-core.php'];

    public function __construct($sOptionKey = null, $sCallerPath = null, $sCapability = 'manage_network', $sTextDomain = 'yucca-shop')
    {
        if (!$this->_isInstantiatable()) {
            return;
        }
        $sCallerPath = $sCallerPath ? $sCallerPath : yucca_shopAdminPageFramework_Utility::getCallerScriptPath(__FILE__);
        $this->oProp = new yucca_shopAdminPageFramework_Property_NetworkAdmin($this, $sCallerPath, get_class($this), $sOptionKey, $sCapability, $sTextDomain);
        parent::__construct($sOptionKey, $sCallerPath, $sCapability, $sTextDomain);
        new yucca_shopAdminPageFramework_Model_Menu__RegisterMenu($this, 'network_admin_menu');
    }

    protected function _getLinkObject()
    {
        return new yucca_shopAdminPageFramework_Link_network_admin_page($this->oProp, $this->oMsg);
    }

    protected function _getPageLoadObject()
    {
        return new yucca_shopAdminPageFramework_PageLoadInfo_network_admin_page($this->oProp, $this->oMsg);
    }

    protected function _isInstantiatable()
    {
        if (isset($GLOBALS['pagenow']) && 'admin-ajax.php' === $GLOBALS['pagenow']) {
            return false;
        }
        if (is_network_admin()) {
            return true;
        }

        return false;
    }

    public static function getOption($sOptionKey, $asKey = null, $vDefault = null)
    {
        return yucca_shopAdminPageFramework_WPUtility::getSiteOption($sOptionKey, $asKey, $vDefault);
    }
}
