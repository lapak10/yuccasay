<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_FieldType_taxonomy extends yucca_shopAdminPageFramework_FieldType_checkbox
{
    public $aFieldTypeSlugs = ['taxonomy'];
    protected $aDefaultKeys = ['taxonomy_slugs' => 'category', 'height' => '250px', 'width' => null, 'max_width' => '100%', 'show_post_count' => true, 'attributes' => [], 'select_all_button' => true, 'select_none_button' => true, 'label_no_term_found' => null, 'label_list_title' => '', 'query' => ['child_of' => 0, 'parent' => '', 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false, 'hierarchical' => true, 'number' => '', 'pad_counts' => false, 'exclude' => [], 'exclude_tree' => [], 'include' => [], 'fields' => 'all', 'slug' => '', 'get' => '', 'name__like' => '', 'description__like' => '', 'offset' => '', 'search' => '', 'cache_domain' => 'core'], 'queries' => []];

    protected function setUp()
    {
        new yucca_shopAdminPageFramework_Form_View___Script_CheckboxSelector();
    }

    protected function getScripts()
    {
        $_aJSArray = json_encode($this->aFieldTypeSlugs);

        return parent::getScripts().<<<JAVASCRIPTS
/* For tabs */
var enableyucca_shopAdminPageFrameworkTabbedBox = function( nodeTabBoxContainer ) {
    jQuery( nodeTabBoxContainer ).each( function() {
        jQuery( this ).find( '.tab-box-tab' ).each( function( i ) {
            
            if ( 0 === i ) {
                jQuery( this ).addClass( 'active' );
            }
                
            jQuery( this ).click( function( e ){
                     
                // Prevents jumping to the anchor which moves the scroll bar.
                e.preventDefault();
                
                // Remove the active tab and set the clicked tab to be active.
                jQuery( this ).siblings( 'li.active' ).removeClass( 'active' );
                jQuery( this ).addClass( 'active' );
                
                // Find the element id and select the content element with it.
                var thisTab = jQuery( this ).find( 'a' ).attr( 'href' );
                active_content = jQuery( this ).closest( '.tab-box-container' ).find( thisTab ).css( 'display', 'block' ); 
                active_content.siblings().css( 'display', 'none' );
                
            });
        });     
    });
};        

jQuery( document ).ready( function() {
         
    enableyucca_shopAdminPageFrameworkTabbedBox( jQuery( '.tab-box-container' ) );

    /* The repeatable event */
    jQuery().registeryucca_shopAdminPageFrameworkCallbacks( {     
        /**
         * The repeatable field callback for the add event.
         * 
         * @param object node
         * @param string    the field type slug
         * @param string    the field container tag ID
         * @param integer    the caller type. 1 : repeatable sections. 0 : repeatable fields.
         */     
        added_repeatable_field: function( oCloned, sFieldType, sFieldTagID, iCallType ) {
            
            // Repeatable Sections
            if ( 1 === iCallType ) {
                var _oSectionsContainer     = jQuery( oCloned ).closest( '.yucca-shop-sections' );
                var _iSectionIndex          = _oSectionsContainer.attr( 'data-largest_index' );
                var _sSectionIDModel        = _oSectionsContainer.attr( 'data-section_id_model' );
                jQuery( oCloned ).find( 'div, li.category-list' ).incrementAttribute(
                    'id', // attribute name
                    _iSectionIndex, // increment from
                    _sSectionIDModel // digit model
                );
                jQuery( oCloned ).find( 'label' ).incrementAttribute(
                    'for', // attribute name
                    _iSectionIndex, // increment from
                    _sSectionIDModel // digit model
                );            
                jQuery( oCloned ).find( 'li.tab-box-tab a' ).incrementAttribute(
                    'href', // attribute name
                    _iSectionIndex, // increment from
                    _sSectionIDModel // digit model
                );                
            } 
            // Repeatable fields 
            else {
                var _oFieldsContainer       = jQuery( oCloned ).closest( '.yucca-shop-fields' );
                var _iFieldIndex            = Number( _oFieldsContainer.attr( 'data-largest_index' ) - 1 );
                var _sFieldTagIDModel       = _oFieldsContainer.attr( 'data-field_tag_id_model' );

                jQuery( oCloned ).find( 'div, li.category-list' ).incrementAttribute(
                    'id', // attribute name
                    _iFieldIndex, // increment from
                    _sFieldTagIDModel // digit model
                );
                jQuery( oCloned ).find( 'label' ).incrementAttribute(
                    'for', // attribute name
                    _iFieldIndex, // increment from
                    _sFieldTagIDModel // digit model
                );            
                jQuery( oCloned ).find( 'li.tab-box-tab a' ).incrementAttribute(
                    'href', // attribute name
                    _iFieldIndex, // increment from
                    _sFieldTagIDModel // digit model
                );
            }
            enableyucca_shopAdminPageFrameworkTabbedBox( jQuery( oCloned ).find( '.tab-box-container' ) );            
            
        }
    
    },
    {$_aJSArray}
    );
});     
JAVASCRIPTS;
    }

    protected function getStyles()
    {
        return '.yucca-shop-field .taxonomy-checklist li { margin: 8px 0 8px 20px; }.yucca-shop-field div.taxonomy-checklist {padding: 8px 0 8px 10px;margin-bottom: 20px;}.yucca-shop-field .taxonomy-checklist ul {list-style-type: none;margin: 0;}.yucca-shop-field .taxonomy-checklist ul ul {margin-left: 1em;}.yucca-shop-field .taxonomy-checklist-label {white-space: nowrap; }.yucca-shop-field .tab-box-container.categorydiv {max-height: none;}.yucca-shop-field .tab-box-tab-text {display: inline-block;}.yucca-shop-field .tab-box-tabs {line-height: 12px;margin-bottom: 0;}.yucca-shop-field .tab-box-tabs .tab-box-tab.active {display: inline;border-color: #dfdfdf #dfdfdf #fff;margin-bottom: 0px;padding-bottom: 2px;background-color: #fff;}.yucca-shop-field .tab-box-container { position: relative; width: 100%; clear: both;margin-bottom: 1em;}.yucca-shop-field .tab-box-tabs li a { color: #333; text-decoration: none; }.yucca-shop-field .tab-box-contents-container {padding: 0 0 0 1.8em;padding: 0.55em 0.5em 0.55em 1.8em;border: 1px solid #dfdfdf; background-color: #fff;}.yucca-shop-field .tab-box-contents { overflow: hidden; overflow-x: hidden; position: relative; top: -1px; height: 300px;}.yucca-shop-field .tab-box-content { display: none; overflow: auto; display: block; position: relative; overflow-x: hidden;}.yucca-shop-field .tab-box-content .taxonomychecklist {margin-right: 3.2em;}.yucca-shop-field .tab-box-content:target, .yucca-shop-field .tab-box-content:target, .yucca-shop-field .tab-box-content:target { display: block; }.yucca-shop-field .tab-box-content .select_all_button_container, .yucca-shop-field .tab-box-content .select_none_button_container{margin-top: 0.8em;}.yucca-shop-field .taxonomychecklist .children {margin-top: 6px;margin-left: 1em;}';
    }

    protected function getIEStyles()
    {
        return '.tab-box-content { display: block; }.tab-box-contents { overflow: hidden;position: relative; }b { position: absolute; top: 0px; right: 0px; width:1px; height: 251px; overflow: hidden; text-indent: -9999px; }';
    }

    protected function getField($aField)
    {
        $aField['label_no_term_found'] = $this->getElement($aField, 'label_no_term_found', $this->oMsg->get('no_term_found'));
        $_aTabs = [];
        $_aCheckboxes = [];
        foreach ($this->getAsArray($aField['taxonomy_slugs']) as $sKey => $sTaxonomySlug) {
            $_aTabs[] = $this->_getTaxonomyTab($aField, $sKey, $sTaxonomySlug);
            $_aCheckboxes[] = $this->_getTaxonomyCheckboxes($aField, $sKey, $sTaxonomySlug);
        }

        return "<div id='tabbox-{$aField['field_id']}' class='tab-box-container categorydiv' style='max-width:{$aField['max_width']};'>"."<ul class='tab-box-tabs category-tabs'>".implode(PHP_EOL, $_aTabs).'</ul>'."<div class='tab-box-contents-container'>"."<div class='tab-box-contents' style='height: {$aField['height']};'>".implode(PHP_EOL, $_aCheckboxes).'</div>'.'</div>'.'</div>';
    }

    private function _getTaxonomyCheckboxes(array $aField, $sKey, $sTaxonomySlug)
    {
        $_aTabBoxContainerArguments = ['id' => "tab_{$aField['input_id']}_{$sKey}", 'class' => 'tab-box-content', 'style' => $this->generateInlineCSS(['height' => $this->sanitizeLength($aField['height']), 'width' => $this->sanitizeLength($aField['width'])])];

        return '<div '.$this->getAttributes($_aTabBoxContainerArguments).'>'.$this->getElement($aField, ['before_label', $sKey]).'<div '.$this->getAttributes($this->_getCheckboxContainerAttributes($aField)).'></div>'."<ul class='list:category taxonomychecklist form-no-clear'>".$this->_getTaxonomyChecklist($aField, $sKey, $sTaxonomySlug).'</ul>'.'<!--[if IE]><b>.</b><![endif]-->'.$this->getElement($aField, ['after_label', $sKey]).'</div><!-- tab-box-content -->';
    }

    private function _getTaxonomyChecklist(array $aField, $sKey, $sTaxonomySlug)
    {
        return wp_list_categories(['walker' => new yucca_shopAdminPageFramework_WalkerTaxonomyChecklist(), 'taxonomy' => $sTaxonomySlug, '_name_prefix' => is_array($aField['taxonomy_slugs']) ? "{$aField['_input_name']}[{$sTaxonomySlug}]" : $aField['_input_name'], '_input_id_prefix' => $aField['input_id'], '_attributes' => $this->getElement($aField, ['attributes', $sKey], []) + $aField['attributes'], '_selected_items' => $this->_getSelectedKeyArray($aField['value'], $sTaxonomySlug), 'echo' => false, 'show_post_count' => $aField['show_post_count'], 'show_option_none' => $aField['label_no_term_found'], 'title_li' => $aField['label_list_title']] + $this->getAsArray($this->getElement($aField, ['queries', $sTaxonomySlug], []), true) + $aField['query']);
    }

    private function _getSelectedKeyArray($vValue, $sTaxonomySlug)
    {
        $vValue = (array) $vValue;
        if (!isset($vValue[$sTaxonomySlug])) {
            return [];
        }
        if (!is_array($vValue[$sTaxonomySlug])) {
            return [];
        }

        return array_keys($vValue[$sTaxonomySlug], true);
    }

    private function _getTaxonomyTab(array $aField, $sKey, $sTaxonomySlug)
    {
        return "<li class='tab-box-tab'>"."<a href='#tab_{$aField['input_id']}_{$sKey}'>"."<span class='tab-box-tab-text'>".$this->_getLabelFromTaxonomySlug($sTaxonomySlug).'</span>'.'</a>'.'</li>';
    }

    private function _getLabelFromTaxonomySlug($sTaxonomySlug)
    {
        $_oTaxonomy = get_taxonomy($sTaxonomySlug);

        return isset($_oTaxonomy->label) ? $_oTaxonomy->label : null;
    }
}
