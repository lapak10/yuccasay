<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_View__PageMataBoxRenderer extends yucca_shopAdminPageFramework_FrameworkUtility
{
    public function render($sContext)
    {
        if (!$this->doesMetaBoxExist()) {
            return;
        }
        $this->_doRender($sContext, ++self::$_iContainerID);
    }

    private static $_iContainerID = 0;

    private function _doRender($sContext, $iContainerID)
    {
        echo "<div id='postbox-container-{$iContainerID}' class='postbox-container'>";
        do_meta_boxes('', $sContext, null);
        echo '</div>';
    }
}
