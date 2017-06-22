<?php
  namespace Metatavu\Pakkasmarja\Settings;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  require_once('settings-ui.php');  
  
  define(PAKKASMARJA_MANAGEMENT_SETTINGS_OPTION, 'pakkasmarja_management');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Settings\Settings' ) ) {

    class Settings {

      public static function getValue($name) {
        $options = get_option(PAKKASMARJA_MANAGEMENT_SETTINGS_OPTION);
        if ($options) {
          return $options[$name];
        }

        return null;
      }
      
    }

  }
  

?>