<?php
  namespace Metatavu\Pakkasmarja\Settings;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Settings\SettingsUI' ) ) {

    class SettingsUI {

      public function __construct() {
        add_action('admin_init', array($this, 'adminInit'));
        add_action('admin_menu', array($this, 'adminMenu'));
      }

      public function adminMenu() {
        add_options_page (__( "Pakkasmarja Settings", 'pakkasmarja_management' ), __( "Pakkasmarja Settings", 'pakkasmarja_management' ), 'manage_options', 'pakkasmarja_management', array($this, 'settingsPage'));
      }

      public function adminInit() {
        register_setting('pakkasmarja_management', 'pakkasmarja_management');
        add_settings_section('api', __( "API Settings", 'pakkasmarja_management' ), null, 'pakkasmarja_management');
        $this->addOption('api', 'url', 'api-url', __( "API URL", 'pakkasmarja_management'));
        $this->addOption('api', 'text', 'client-id', __( "Client Id", 'pakkasmarja_management' ));
        $this->addOption('api', 'text', 'client-secret', __( "Client Secret", 'pakkasmarja_management' ));
      }

      private function addOption($group, $type, $name, $title) {
        add_settings_field($name, $title, array($this, 'createFieldUI'), 'pakkasmarja_management', $group, [
          'name' => $name, 
          'type' => $type
        ]);
      }

      public function createFieldUI($opts) {
        $name = $opts['name'];
        $type = $opts['type'];
        $value = Settings::getValue($name);
        echo "<input id='$name' name='" . 'pakkasmarja_management' . "[$name]' size='42' type='$type' value='$value' />";
      }

      public function settingsPage() {
        if (!current_user_can('manage_options')) {
          wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        echo '<div class="wrap">';
        echo "<h2>" . __( "Pakkasmarja Management", 'pakkasmarja_management') . "</h2>";
        echo '<form action="options.php" method="POST">';
        settings_fields('pakkasmarja_management');
        do_settings_sections('pakkasmarja_management');
        submit_button();
        echo "</form>";
        echo "</div>";
      }
    }

  }
  
  if (is_admin()) {
    $settingsUI = new SettingsUI();
  }

?>