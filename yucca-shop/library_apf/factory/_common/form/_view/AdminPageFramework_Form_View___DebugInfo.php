<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_View___DebugInfo extends yucca_shopAdminPageFramework_FrameworkUtility
{
    public $sStructureType = '';
    public $oMsg;

    public function __construct()
    {
        $_aParameters = func_get_args() + [$this->sStructureType, $this->oMsg];
        $this->sStructureType = $_aParameters[0];
        $this->oMsg = $_aParameters[1];
    }

    public function get()
    {
        if (!$this->isDebugModeEnabled()) {
            return '';
        }
        if (!in_array($this->sStructureType, ['widget', 'post_meta_box', 'page_meta_box', 'user_meta'])) {
            return '';
        }

        return "<div class='yucca-shop-info'>".$this->oMsg->get('debug_info').': '.yucca_shopAdminPageFramework_Registry::NAME.' '.yucca_shopAdminPageFramework_Registry::getVersion().'</div>';
    }
}
