<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Form_View___CSS_Form extends yucca_shopAdminPageFramework_Form_View___CSS_Base
{
    protected function _get()
    {
        $_sSpinnerURL = esc_url(admin_url('/images/wpspin_light-2x.gif'));

        return '.yucca-shop-form-warning {font-weight: bold;color: red;font-size: 1.32em;}';
    }
}
