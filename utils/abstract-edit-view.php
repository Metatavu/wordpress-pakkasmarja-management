<?php
  
  namespace Metatavu\Pakkasmarja\Utils;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  if (!class_exists( '\Metatavu\Pakkasmarja\Utils\AbstractEditView' ) ) {
    
    class AbstractEditView {

      /**
       * Renders contract form start
       */
      protected function renderFormStart($action) {
        echo sprintf('<form class="pakkasmarja-form" method="post" action="%s">', $action);
        echo '<div id="poststuff">';
        wp_nonce_field();
      }
      
      /**
       * Renders contract form end
       */
      protected function renderFormEnd() {
        submit_button();
        echo '</form></div>';
      }

      /**
       * Renders a text input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      protected function renderTextInput($label, $name, $value) {
        echo sprintf('<h3>%s</h3>', $label);
        echo sprintf('<input type="text" name="%s" value="%s" />', $name, htmlspecialchars($value));
      }

      /**
       * Renders a memo input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      protected function renderMemoInput($label, $name, $value, $rows = 5) {
        echo sprintf('<h3>%s</h3>', $label);
        echo sprintf('<textarea name="%s" rows="%d">%s</textarea>', $name, $rows, htmlspecialchars($value));
      }

      /**
       * Renders a memo input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      protected function renderRichInput($label, $name, $value) {
        echo sprintf('<h3>%s</h3>', $label);
        wp_editor($value, $name);
      }

      /**
       * Renders a number input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      protected function renderNumberInput($label, $name, $value) {
        echo sprintf('<h3>%s</h3>', $label);
        echo sprintf('<input type="number" name="%s" value="%s" />', $name, htmlspecialchars($value));
      }

      /**
       * Renders a dropdown input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       * @param array $options array of options in key value pairs  
       */
      protected function renderDropdownInput($label, $name, $value, $options) {
        echo sprintf('<h3>%s</h3>', $label);
        echo sprintf('<select name="%s">', $name);

        foreach ($options as $name => $text) {
          $checked = $name === $value ? ' selected="selected"' : '';
          echo sprintf('<option value="%s"%s>%s</option>', $name, $checked, htmlspecialchars($text));
        }

        echo "</select>";
      }

      /**
       * Returns string value from POST request
       * 
       * @param String $name variable name
       * @return String value
       */
      protected function getPostString($name) {
        return sanitize_text_field($this->getRawPostString($name));
      }

      /**
       * Returns multiline string value from POST request
       * 
       * @param String $name variable name
       * @return String value
       */
      protected function getMemoPostString($name) {
        return sanitize_textarea_field($this->getRawPostString($name));
      }

      /**
       * Returns raw string value from POST request
       * 
       * @param String $name variable name
       * @return String value
       */
      protected function getRawPostString($name) {
        return $_POST[$name];
      }

      /**
       * Returns int value from POST request
       * 
       * @param String $name variable name
       * @return int value
       */
      protected function getPostInt($name) {
        return intval($this->getPostString($name));
      }
    }

  }

?>