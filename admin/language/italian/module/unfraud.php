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
$_['text_module']      = 'Moduli';
$_['text_success']     = 'Hai modificato con successo il modulo Unfraud!';
$_['text_content_top']    = 'Content Top';
$_['text_content_bottom'] = 'Content Bottom';
$_['text_column_left']    = 'Column Left';
$_['text_column_right']   = 'Column Right';

// Entry
$_['entry_unfraud_debug']       = 'Debug:'; // this will be pulled through to the controller, then made available to be displayed in the view.
$_['entry_apikey']       = 'API Key:';
$_['entry_email']       = 'E-mail:';
$_['entry_password']       = 'Password:';
$_['entry_threshold']       = 'Soglia Antifrode:';
$_['entry_image']        = 'Immagine (LxA):';
$_['entry_limit']        = 'Limit:';
$_['entry_layout']        = 'Layout:';
$_['entry_position']      = 'Posizione:';
$_['entry_status']        = 'Status:';
$_['entry_sort_order']    = 'Ordine per:';

// Error
$_['entry_configuration_error']       = 'E\' necessario configurare i parametri API KEY, EMAIL e PASSWORD nelle configurazioni del plugin'; // this will be pulled through to the controller, then made available to be displayed in the view.
$_['entry_credentials_error'] = "Le tue credenziali di accesso sono errate. Per favore cambia EMAIL e PASSWORD nelle configurazioni del plugin.";
$_['error_permission'] = 'Attenzione: Non hai i permessi per poter modificare il modulo Unfraud!';
?>