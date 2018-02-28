<?php
/*
 * Created on Jun 21, 2017
 * Plugin Name: Pakkasmarja Management
 * Description: Management functions for Pakkasmarja Application
 * Version: 0.0.1
 * Author: Metatavu Oy
 */

  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );
  
  if (!defined('PAKKASMARJA_MANAGEMENT_I18N_DOMAIN')) {
    define('PAKKASMARJA_MANAGEMENT_I18N_DOMAIN', 'pakkasmarja_management');
  }

  require_once( __DIR__ . '/capabilities/capabilities.php');
  require_once( __DIR__ . '/chat-threads/chat-threads.php');
  require_once( __DIR__ . '/question-groups/question-groups.php');
  require_once( __DIR__ . '/settings/settings.php');
  require_once( __DIR__ . '/webhooks/webhook-handler.php');
  require_once( __DIR__ . '/operations/operations.php');
  
  add_action('plugins_loaded', function() {
    load_plugin_textdomain( PAKKASMARJA_MANAGEMENT_I18N_DOMAIN, false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
  });

  register_activation_hook(__FILE__, ['\Metatavu\Pakkasmarja\Capabilities', 'activationHook']);
  register_deactivation_hook(__FILE__, ['\Metatavu\Pakkasmarja\Capabilities', 'deactivationHook']);
?>
