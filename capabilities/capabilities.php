<?php

  namespace Metatavu\Pakkasmarja;
  
  require_once( __DIR__ . '/../vendor/autoload.php');
  require_once( __DIR__ . '/../settings/settings.php');
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Capabilities' ) ) {
  
    class Capabilities {
      
      private static $capabilities = [
        'pakkasmarja_operations_create',
        'pakkasmarja_operations_view',
        'pakkasmarja_contracts_view',
        'pakkasmarja_contracts_edit',
        'pakkasmarja_item_groups_view',
        'pakkasmarja_item_group_document_templates_view',
        'pakkasmarja_item_group_document_templates_edit'
      ];
      
      /**
       * Plugin activation hook
       */
      public static function activationHook() {
        self::addCapabilities('administrator');
        self::addCapabilities('editor');
      }
      
      /**
       * Plugin deactivation hook
       */
      public static function deactivationHook() {
        self::removeCapabilities('administrator');
        self::removeCapabilities('editor');
      }
      
      /**
       * Activates capabilities for given role
       * 
       * @param string $roleName role
       */
      private static function addCapabilities($roleName) {
        $role = get_role($roleName);
        
        foreach (self::$capabilities as $capability) {
          $role->add_cap($capability, true);  
        }
      }
      
      /**
       * Deactivates capabilities for given role
       * 
       * @param string $roleName role
       */
      private static function removeCapabilities($roleName) {
        $role = get_role($roleName);        
        foreach (self::$capabilities as $capability) {
          $role->remove_cap($capability);
        }
      }
        
    }
  }

?>