<?php
  
  namespace Metatavu\Pakkasmarja\Utils;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  require_once( __DIR__ . '/../vendor/autoload.php');

  if (!class_exists( '\Metatavu\Pakkasmarja\Utils\AbstractEditView' ) ) {
    
    class AbstractEditView {

      /**
       * @var \Metatavu\Pakkasmarja\Api\ContractsApi
       */
      private $contractsApi;

      /**
       * @var \Metatavu\Pakkasmarja\Api\ItemGroupsApi
       */
      private $itemGroupsApi;

      /**
       * Constructorr
       */
      public function __construct() {
        $this->contractsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi();
        $this->itemGroupsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi();
      }

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
       * Renders a text field
       * 
       * @param String $label input label
       * @param String $value input value
       */
      protected function renderTextField($label, $value) {
        if ($value) {
          echo sprintf('<h3>%s</h3>', $label);
          echo sprintf('<p>%s</p>', htmlspecialchars($value));
        }
      }

      /**
       * Renders an inline text field
       * 
       * @param String $label input label
       * @param String $value input value
       */
      protected function renderInlineTextField($label, $value) {
        if ($value) {
          echo sprintf('<p style="font-size: 18px;">%s: <b>%s</b></p>', $label, htmlspecialchars($value));
        }
      }

      /**
       * Renders a line
       */
      protected function renderLine() {
        echo '<br/><br/><hr/>';
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

      /**
       * Finds an item group by id
       * 
       * @return array array containing delivery places  
       */
      protected function findItemGroupById($id) {
        try {
          return $this->itemGroupsApi->findItemGroup($id);
        } catch (\Metatavu\Pakkasmarja\ApiException $e) {
          echo '<div class="error notice">';
          if ($e->getResponseBody()) {
            echo print_r($e->getResponseBody());
          } else {
            echo $e;
          }

          echo '</div>';
        }
      }

      /**
       * Finds an item group document template
       *
       * @param string $itemGroupId item group id (required)
       * @param string $itemGroupDocumentTemplateId item group document template id (required)
       *
       * @return \Metatavu\Pakkasmarja\Api\Model\ContractItemGroupDocumentTemplate
       */
      protected function findItemGroupDocumentTemplate($itemGroupId, $itemGroupDocumentTemplateId) {
        try {
          return $this->itemGroupsApi->findItemGroupDocumentTemplate($itemGroupId, $itemGroupDocumentTemplateId);
        } catch (\InvalidArgumentException $e) {
          $message = $e->getMessage();
          error_log("Failed to find item group document template #$itemGroupDocumentTemplateId: $message");
          return null;
        } catch (\Metatavu\Pakkasmarja\ApiException $e) {
          $message = $e->getMessage();
          error_log("Failed to find item group document template #$itemGroupDocumentTemplateId: $message");
          return null;
        }
      }

      /**
       * Finds a contract by id
       *
       * @param string $contractId contract id (required)
       *
       * @return \Metatavu\Pakkasmarja\Api\Model\Contract
       */
      protected function findContractById($contractId) {
        try {
          return $this->contractsApi->findContract($contractId);
        } catch (\InvalidArgumentException $e) {
          $message = $e->getMessage();
          error_log("Failed to find contract #$contractId: $message");
          return null;
        } catch (\Metatavu\Pakkasmarja\ApiException $e) {
          $message = $e->getMessage();
          error_log("Failed to find contract #$contractId: $message");
          return null;
        }
      }
    }

  }

?>