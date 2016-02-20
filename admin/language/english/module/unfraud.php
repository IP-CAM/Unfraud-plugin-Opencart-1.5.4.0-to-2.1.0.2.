<?php
################################################################################################
#  DIY Module Builder for Opencart 1.5.1.x From HostJars http://opencart.hostjars.com   	   #
################################################################################################

/*
 * This file contains the english version of any static text required by your module in the admin area.
 * If you want to translate your module to another language, the idea is that you can just replace the
 * right hand column below with the changed language, rather than modifying every file in your module.
 * 
 * We will call these language strings through in the controller to make them available in the view. 
 * 
 * For your module, think about any text that you want to display and add it in here. Also replace all the
 * "My Module" text for the name of your module.
 * 
 */

// Example field added (see related part in admin/controller/module/my_module.php)
$_['unfraud_example'] = 'Example Extra Text';



// Heading Goes here:
$_['heading_title']    = 'Unfraud';


// Text
$_['text_module']      = 'Modules';
$_['text_success']     = 'Success: You have modified module Unfraud!';
$_['text_content_top']    = 'Content Top';
$_['text_content_bottom'] = 'Content Bottom';
$_['text_column_left']    = 'Column Left';
$_['text_column_right']   = 'Column Right';

// Entry
$_['entry_debug']       = 'Debug:'; // this will be pulled through to the controller, then made available to be displayed in the view.
$_['entry_apikey']       = 'API Key:'; 
$_['entry_email']       = 'E-mail:'; 
$_['entry_password']       = 'Password:';
$_['entry_threshold']       = 'Anti-Fraud Treshold:';
$_['entry_image']        = 'Image (WxH):';
$_['entry_limit']        = 'Limit:';
$_['entry_layout']        = 'Layout:';
$_['entry_position']      = 'Position:';
$_['entry_status']        = 'Status:';
$_['entry_sort_order']    = 'Sort Order:';

// Error
$_['entry_configuration_error']       = 'You need to add API KEY, EMAIL and PASSWORD in plugin configuration'; // this will be pulled through to the controller, then made available to be displayed in the view.
$_['error_permission'] = 'Warning: You do not have permission to modify module Unfraud!';
$_['entry_credentials_error'] = "Your user credentials are incorrect. Please change your EMAIL and PASSWORD in plugin configuration.";

?>