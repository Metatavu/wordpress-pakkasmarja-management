<?php
  
  namespace Metatavu\Pakkasmarja\ItemGroups;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  use \Metatavu\Pakkasmarja\Utils\Formatter;
  
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../utils/formatter.php');
  require_once( __DIR__ . '/../utils/abstract-edit-view.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Contracts\ItemGroupDocumentTemplateEditView' ) ) {
    
    class ItemGroupDocumentTemplateEditView extends \Metatavu\Pakkasmarja\Utils\AbstractEditView {

      private $capability = 'pakkasmarja_item_group_document_templates_edit';
      
      /**
       * @var \Metatavu\Pakkasmarja\Api\ItemGroupsApi
       */
      private $itemGroupsApi;
      
      /**
       * Constructorr
       */
      public function __construct() {
        parent::__construct();

        $this->itemGroupsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi();

        add_action( 'admin_menu', function () {
          add_submenu_page(NULL, __('Edit Item Group Document Template', 'pakkasmarja_management'), __('Edit Item Group Document Template', 'pakkasmarja_management'), $this->capability, 'pakkasmarja-item-group-document-template-edit-view.php', [ $this, 'renderEditView' ]);
        });
      }

      /**
       * Renders edit view
       */
      public function renderEditView() {
        $itemGroupId = sanitize_text_field($_GET['item-group-id']);
        $id = sanitize_text_field($_GET['id']);
        $itemGroupDocumentTemplate = $this->findItemGroupDocumentTemplate($itemGroupId, $id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $validateMessage = $this->validatePost();
          if ($validateMessage) {
            echo '<div class="notice-error notice">' . $validateMessage . '</div>';
          } else {
            $contents = apply_filters("the_content", stripslashes($this->getRawPostString("contents")));
            $header = apply_filters("the_content", stripslashes($this->getRawPostString("header")));
            $footer = apply_filters("the_content", stripslashes($this->getRawPostString("footer")));

            if (!$this->updateItemGroupDocumentTemplate($itemGroupDocumentTemplate, $contents, $header, $footer)) {
              echo sprintf('<div class="notice-error notice">%s</div>', htmlspecialchars(__('Failed to update contract', 'pakkasmarja_management')));
            }
          }
        }

        $itemGroup = $this->findItemGroupById($itemGroupId);
        $itemGroupName = $itemGroup->getName();
        $documentTemplateType = $itemGroupDocumentTemplate->getType();

        wp_enqueue_style('pakkasmarja-forms', plugin_dir_url(__FILE__) . '../forms.css');

        echo '<div class="wrap">';
        $backLink = sprintf('<a href="%s" class="page-title-action">%s</a>', "?page=item-group.php", __('Back', 'pakkasmarja_management'));
        echo sprintf('<h1 class="wp-heading-inline">%s - %s %s</h1><br/><br/>', $itemGroupName, Formatter::formatDocumentTemplateType($documentTemplateType), $backLink);
        echo '<hr class="wp-header-end"/>';

        $this->renderTemplateForm($itemGroupDocumentTemplate);

        echo '</div>';
      }

      /**
       * Validates post request
       * 
       * @return String validation message or null if no validation errors have been found
       */
      private function validatePost() {
        return null;
      }

      /**
       * Renders contract edit form
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate $itemGroupDocumentTemplate item group document template
       */
      private function renderTemplateForm($itemGroupDocumentTemplate) {
        $action = sprintf('admin.php?page=pakkasmarja-item-group-document-template-edit-view.php&action=edit&item-group-id=%s&id=%s', $itemGroupDocumentTemplate->getItemGroupId(), $itemGroupDocumentTemplate->getId());
        $this->renderFormStart($action);
        $this->renderFormFields($itemGroupDocumentTemplate);
        $this->renderFormEnd();
      }

      /**
       * Renders contract form fields
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate $itemGroupDocumentTemplate item group document template
       */
      private function renderFormFields($itemGroupDocumentTemplate) {
        $this->renderRichInput(__('Contents', 'pakkasmarja_management'), "contents", $itemGroupDocumentTemplate->getContents());
        $this->renderRichInput(__('Header', 'pakkasmarja_management'), "header", $itemGroupDocumentTemplate->getHeader());
        $this->renderRichInput(__('Footer', 'pakkasmarja_management'), "footer", $itemGroupDocumentTemplate->getFooter());
      }

      /** 
       * Returns company name from contract
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $itemGroupDocumentTemplate contract
       * @return String company name
       */
      private function getCompanyName($itemGroupDocumentTemplate) {
        return Formatter::getCompanyName($itemGroupDocumentTemplate->getContactId());
      }

      /** 
       * Returns item group name from contract
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $itemGroupDocumentTemplate contract
       * @return String item group name
       */
      private function getItemGroupName($itemGroupDocumentTemplate) {
        return Formatter::getItemGroupName($itemGroupDocumentTemplate->getItemGroupId());
      }

      /**
       * Updates contract
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $itemGroupDocumentTemplate contract
       * @param int $itemGroupDocumentTemplateQuantity new contract quantity
       * @param String $status new status
       * @param String $deliveryPlaceId new delivery place id
       * @return \Metatavu\Pakkasmarja\Api\Model\Contract updated contract
       */
      private function updateContract($itemGroupDocumentTemplate, $itemGroupDocumentTemplateQuantity, $status, $deliveryPlaceId) {
        try {
          $itemGroupDocumentTemplate->setContractQuantity($itemGroupDocumentTemplateQuantity);
          $itemGroupDocumentTemplate->setStatus($status);
          $itemGroupDocumentTemplate->setDeliveryPlaceId($deliveryPlaceId);
          return $this->contractsApi->updateContract($itemGroupDocumentTemplate->getId(), $itemGroupDocumentTemplate);
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
       * Updates item group document template
       * 
       * @param string $itemGroupDocumentTemplate item group document template id (required)
       * @param string $contents contents contents
       * @param string $header header header
       * @param string $footer footer footer
       */
      private function updateItemGroupDocumentTemplate($itemGroupDocumentTemplate, $contents, $header, $footer) {
        try {
          $itemGroupDocumentTemplate->setContents($contents);
          $itemGroupDocumentTemplate->setHeader($header);
          $itemGroupDocumentTemplate->setFooter($footer);
          return $this->itemGroupsApi->updateItemGroupDocumentTemplate($itemGroupDocumentTemplate->getItemGroupId(), $itemGroupDocumentTemplate->getId(), $itemGroupDocumentTemplate);
        } catch (\Metatavu\Pakkasmarja\ApiException | \InvalidArgumentException $e) {
          $message = $e->getMessage();
          error_log("Failed to find item group document template #$itemGroupDocumentTemplateId: $message");
          return null;
        }
      }

    }
  }
  
  add_action('init', function () {
    if (is_admin()) {
      new ItemGroupDocumentTemplateEditView();
    }
  });
    
?>