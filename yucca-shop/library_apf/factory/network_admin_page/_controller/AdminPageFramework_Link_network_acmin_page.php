<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Link_network_admin_page extends yucca_shopAdminPageFramework_Link_admin_page
{
    public function __construct($oProp, $oMsg = null)
    {
        parent::__construct($oProp, $oMsg);
        if (in_array($this->oProp->sPageNow, ['plugins.php']) && 'plugin' === $this->oProp->aScriptInfo['sType']) {
            remove_filter('plugin_action_links_'.plugin_basename($this->oProp->aScriptInfo['sPath']), [$this, '_replyToAddSettingsLinkInPluginListingPage'], 20);
            add_filter('network_admin_plugin_action_links_'.plugin_basename($this->oProp->aScriptInfo['sPath']), [$this, '_replyToAddSettingsLinkInPluginListingPage']);
        }
    }

    protected $_sFilterSuffix_PluginActionLinks = 'network_admin_plugin_action_links_';
}
