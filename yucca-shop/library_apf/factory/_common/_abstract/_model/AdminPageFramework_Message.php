<?php

/**
 <http://en.michaeluno.jp/yucca-shop>
 Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class yucca_shopAdminPageFramework_Message
{
    public $aMessages = [];
    public $aDefaults = ['option_updated' => 'The options have been updated.', 'option_cleared' => 'The options have been cleared.', 'export' => 'Export', 'export_options' => 'Export Options', 'import_options' => 'Import', 'import_options' => 'Import Options', 'submit' => 'Submit', 'import_error' => 'An error occurred while uploading the import file.', 'uploaded_file_type_not_supported' => 'The uploaded file type is not supported: %1$s', 'could_not_load_importing_data' => 'Could not load the importing data.', 'imported_data' => 'The uploaded file has been imported.', 'not_imported_data' => 'No data could be imported.', 'upload_image' => 'Upload Image', 'use_this_image' => 'Use This Image', 'insert_from_url' => 'Insert from URL', 'reset_options' => 'Are you sure you want to reset the options?', 'confirm_perform_task' => 'Please confirm your action.', 'specified_option_been_deleted' => 'The specified options have been deleted.', 'nonce_verification_failed' => 'A problem occurred while processing the form data. Please try again.', 'check_max_input_vars' => 'Not all form fields could not be sent. Please check your server settings of PHP <code>max_input_vars</code> and consult the server administrator to increase the value. <code>max input vars</code>: %1$s. <code>$_POST</code> count: %2$s', 'send_email' => 'Is it okay to send the email?', 'email_sent' => 'The email has been sent.', 'email_scheduled' => 'The email has been scheduled.', 'email_could_not_send' => 'There was a problem sending the email', 'title' => 'Title', 'author' => 'Author', 'categories' => 'Categories', 'tags' => 'Tags', 'comments' => 'Comments', 'date' => 'Date', 'show_all' => 'Show All', 'show_all_authors' => 'Show all Authors', 'powered_by' => 'Thank you for creating with', 'and' => 'and', 'settings' => 'Settings', 'manage' => 'Manage', 'select_image' => 'Select Image', 'upload_file' => 'Upload File', 'use_this_file' => 'Use This File', 'select_file' => 'Select File', 'remove_value' => 'Remove Value', 'select_all' => 'Select All', 'select_none' => 'Select None', 'no_term_found' => 'No term found.', 'select' => 'Select', 'insert' => 'Insert', 'use_this' => 'Use This', 'return_to_library' => 'Return to Library', 'queries_in_seconds' => '%1$s queries in %2$s seconds.', 'out_of_x_memory_used' => '%1$s out of %2$s MB (%3$s) memory used.', 'peak_memory_usage' => 'Peak memory usage %1$s MB.', 'initial_memory_usage' => 'Initial memory usage  %1$s MB.', 'allowed_maximum_number_of_fields' => 'The allowed maximum number of fields is {0}.', 'allowed_minimum_number_of_fields' => 'The allowed minimum number of fields is {0}.', 'add' => 'Add', 'remove' => 'Remove', 'allowed_maximum_number_of_sections' => 'The allowed maximum number of sections is {0}', 'allowed_minimum_number_of_sections' => 'The allowed minimum number of sections is {0}', 'add_section' => 'Add Section', 'remove_section' => 'Remove Section', 'toggle_all' => 'Toggle All', 'toggle_all_collapsible_sections' => 'Toggle all collapsible sections', 'reset' => 'Reset', 'yes' => 'Yes', 'no' => 'No', 'on' => 'On', 'off' => 'Off', 'enabled' => 'Enabled', 'disabled' => 'Disabled', 'supported' => 'Supported', 'not_supported' => 'Not Supported', 'functional' => 'Functional', 'not_functional' => 'Not Functional', 'too_long' => 'Too Long', 'acceptable' => 'Acceptable', 'no_log_found' => 'No log found.', 'method_called_too_early' => 'The method is called too early.', 'debug_info' => 'Debug Info', 'click_to_expand' => 'Click here to expand to view the contents.', 'click_to_collapse' => 'Click here to collapse the contents.', 'loading' => 'Loading...', 'please_enable_javascript' => 'Please enable JavaScript for better experience.'];
    protected $_sTextDomain = 'yucca-shop';
    private static $_aInstancesByTextDomain = [];

    public static function getInstance($sTextDomain = 'yucca-shop')
    {
        $_oInstance = isset(self::$_aInstancesByTextDomain[$sTextDomain]) && (self::$_aInstancesByTextDomain[$sTextDomain] instanceof self) ? self::$_aInstancesByTextDomain[$sTextDomain] : new self($sTextDomain);
        self::$_aInstancesByTextDomain[$sTextDomain] = $_oInstance;

        return self::$_aInstancesByTextDomain[$sTextDomain];
    }

    public static function instantiate($sTextDomain = 'yucca-shop')
    {
        return self::getInstance($sTextDomain);
    }

    public function __construct($sTextDomain = 'yucca-shop')
    {
        $this->_sTextDomain = $sTextDomain;
        $this->aMessages = array_fill_keys(array_keys($this->aDefaults), null);
    }

    public function getTextDomain()
    {
        return $this->_sTextDomain;
    }

    public function set($sKey, $sValue)
    {
        $this->aMessages[$sKey] = $sValue;
    }

    public function get($sKey = '')
    {
        if (!$sKey) {
            return $this->_getAllMessages();
        }

        return isset($this->aMessages[$sKey]) ? __($this->aMessages[$sKey], $this->_sTextDomain) : __($this->{$sKey}, $this->_sTextDomain);
    }

    private function _getAllMessages()
    {
        $_aMessages = [];
        foreach ($this->aMessages as $_sLabel => $_sTranslation) {
            $_aMessages[$_sLabel] = $this->get($_sLabel);
        }

        return $_aMessages;
    }

    public function output($sKey)
    {
        echo $this->get($sKey);
    }

    public function __($sKey)
    {
        return $this->get($sKey);
    }

    public function _e($sKey)
    {
        $this->output($sKey);
    }

    public function __get($sPropertyName)
    {
        return isset($this->aDefaults[$sPropertyName]) ? $this->aDefaults[$sPropertyName] : $sPropertyName;
    }

    private function __doDummy()
    {
        __('The options have been updated.', 'yucca-shop');
        __('The options have been cleared.', 'yucca-shop');
        __('Export', 'yucca-shop');
        __('Export Options', 'yucca-shop');
        __('Import', 'yucca-shop');
        __('Import Options', 'yucca-shop');
        __('Submit', 'yucca-shop');
        __('An error occurred while uploading the import file.', 'yucca-shop');
        __('The uploaded file type is not supported: %1$s', 'yucca-shop');
        __('Could not load the importing data.', 'yucca-shop');
        __('The uploaded file has been imported.', 'yucca-shop');
        __('No data could be imported.', 'yucca-shop');
        __('Upload Image', 'yucca-shop');
        __('Use This Image', 'yucca-shop');
        __('Insert from URL', 'yucca-shop');
        __('Are you sure you want to reset the options?', 'yucca-shop');
        __('Please confirm your action.', 'yucca-shop');
        __('The specified options have been deleted.', 'yucca-shop');
        __('A problem occurred while processing the form data. Please try again.', 'yucca-shop');
        __('Not all form fields could not be sent. Please check your server settings of PHP <code>max_input_vars</code> and consult the server administrator to increase the value. <code>max input vars</code>: %1$s. <code>$_POST</code> count: %2$s', 'yucca-shop');
        __('Is it okay to send the email?', 'yucca-shop');
        __('The email has been sent.', 'yucca-shop');
        __('The email has been scheduled.', 'yucca-shop');
        __('There was a problem sending the email', 'yucca-shop');
        __('Title', 'yucca-shop');
        __('Author', 'yucca-shop');
        __('Categories', 'yucca-shop');
        __('Tags', 'yucca-shop');
        __('Comments', 'yucca-shop');
        __('Date', 'yucca-shop');
        __('Show All', 'yucca-shop');
        __('Show All Authors', 'yucca-shop');
        __('Thank you for creating with', 'yucca-shop');
        __('and', 'yucca-shop');
        __('Settings', 'yucca-shop');
        __('Manage', 'yucca-shop');
        __('Select Image', 'yucca-shop');
        __('Upload File', 'yucca-shop');
        __('Use This File', 'yucca-shop');
        __('Select File', 'yucca-shop');
        __('Remove Value', 'yucca-shop');
        __('Select All', 'yucca-shop');
        __('Select None', 'yucca-shop');
        __('No term found.', 'yucca-shop');
        __('Select', 'yucca-shop');
        __('Insert', 'yucca-shop');
        __('Use This', 'yucca-shop');
        __('Return to Library', 'yucca-shop');
        __('%1$s queries in %2$s seconds.', 'yucca-shop');
        __('%1$s out of %2$s MB (%3$s) memory used.', 'yucca-shop');
        __('Peak memory usage %1$s MB.', 'yucca-shop');
        __('Initial memory usage  %1$s MB.', 'yucca-shop');
        __('The allowed maximum number of fields is {0}.', 'yucca-shop');
        __('The allowed minimum number of fields is {0}.', 'yucca-shop');
        __('Add', 'yucca-shop');
        __('Remove', 'yucca-shop');
        __('The allowed maximum number of sections is {0}', 'yucca-shop');
        __('The allowed minimum number of sections is {0}', 'yucca-shop');
        __('Add Section', 'yucca-shop');
        __('Remove Section', 'yucca-shop');
        __('Toggle All', 'yucca-shop');
        __('Toggle all collapsible sections', 'yucca-shop');
        __('Reset', 'yucca-shop');
        __('Yes', 'yucca-shop');
        __('No', 'yucca-shop');
        __('On', 'yucca-shop');
        __('Off', 'yucca-shop');
        __('Enabled', 'yucca-shop');
        __('Disabled', 'yucca-shop');
        __('Supported', 'yucca-shop');
        __('Not Supported', 'yucca-shop');
        __('Functional', 'yucca-shop');
        __('Not Functional', 'yucca-shop');
        __('Too Long', 'yucca-shop');
        __('Acceptable', 'yucca-shop');
        __('No log found.', 'yucca-shop');
        __('The method is called too early: %1$s', 'yucca-shop');
        __('Debug Info', 'yucca-shop');
        __('Click here to expand to view the contents.', 'yucca-shop');
        __('Click here to collapse the contents.', 'yucca-shop');
        __('Loading...', 'yucca-shop');
        __('Please enable JavaScript for better experience.', 'yucca-shop');
    }
}
