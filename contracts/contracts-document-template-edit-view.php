<?php
  
  namespace Metatavu\Pakkasmarja\Contracts;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  use \Metatavu\Pakkasmarja\Utils\Formatter;
  
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../utils/formatter.php');
  require_once( __DIR__ . '/../utils/abstract-edit-view.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Contracts\ContractDocumentTemplateEditView' ) ) {
    
    class ContractDocumentTemplateEditView extends \Metatavu\Pakkasmarja\Utils\AbstractEditView {

      private $capability = 'pakkasmarja_contract_document_templates_edit';
      
      /**
       * @var \Metatavu\Pakkasmarja\Api\ContractsApi
       */
      private $contractsApi;
      
      /**
       * Constructorr
       */
      public function __construct() {
        parent::__construct();

        $this->contractsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi();

        add_action( 'admin_menu', function () {
          add_submenu_page(NULL, __('Edit Contract Document Template', 'pakkasmarja_management'), __('Edit Contract Document Template', 'pakkasmarja_management'), $this->capability, 'pakkasmarja-contracts-document-template-edit-view.php', [ $this, 'renderEditView' ]);
        });
      }

      /**
       * Renders edit view
       */
      public function renderEditView() {
        $contractId = sanitize_text_field($_GET['contract-id']);
        $itemGroupId = sanitize_text_field($_GET['item-group-id']);
        $itemGroupDocumentTemplateId = sanitize_text_field($_GET['item-group-document-template-id']);
        $itemGroup = $this->findItemGroupById($itemGroupId);
        $itemGroupDocumentTemplate = $this->findItemGroupDocumentTemplate($itemGroupId, $itemGroupDocumentTemplateId);
        $contract = $this->findContractById($contractId);
        $contractDocumentTemplate = $this->findContractDocumentTemplate($contract, $itemGroupDocumentTemplate);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $validateMessage = $this->validatePost();
          if ($validateMessage) {
            echo '<div class="notice-error notice">' . $validateMessage . '</div>';
          } else {
            $contents = apply_filters("the_content", stripslashes($this->getRawPostString("contents")));
            $header = apply_filters("the_content", stripslashes($this->getRawPostString("header")));
            $footer = apply_filters("the_content", stripslashes($this->getRawPostString("footer")));
            if (!$this->updateContractDocumentTemplate($contractDocumentTemplate, $contractId, $itemGroupDocumentTemplate->getType(), $contents, $header, $footer)) {
              echo sprintf('<div class="notice-error notice">%s</div>', htmlspecialchars(__('Failed to update contract document template', 'pakkasmarja_management')));
            }
          }
        }

        $title = sprintf(__('Edit %s document template %s', 'pakkasmarja_management'), $this->getCompanyName($contract), Formatter::formatDocumentTemplateType($itemGroupDocumentTemplate->getType()));
        wp_enqueue_style('pakkasmarja-forms', plugin_dir_url(__FILE__) . '../forms.css');

        echo '<div class="wrap">';
        $backLink = sprintf('<a href="%s" class="page-title-action">%s</a>', "?page=contract.php", __('Back', 'pakkasmarja_management'));
        echo sprintf('<h1 class="wp-heading-inline">%s %s</h1><br/><br/>', $title, $backLink);
        echo '<hr class="wp-header-end"/>';

        $this->renderTemplateForm($itemGroupDocumentTemplate, $contractDocumentTemplate, $contract);

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
       * @param \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate $contractDocumentTemplate contract document template
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $contract contract
       */
      private function renderTemplateForm($itemGroupDocumentTemplate, $contractDocumentTemplate, $contract) {
        $action = sprintf("admin.php?page=pakkasmarja-contracts-document-template-edit-view.php&item-group-document-template-id=%s&item-group-id=%s&contract-id=%s", $itemGroupDocumentTemplate->getId(), $itemGroupDocumentTemplate->getItemGroupId(), $contract->getId());
        $this->renderFormStart($action);
        $this->renderFormFields($itemGroupDocumentTemplate, $contractDocumentTemplate);
        $this->renderFormEnd();
      }

      /**
       * Renders contract form fields. Template contents are loaded from contract document if it's provided, otherwise item group template is used.
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate $itemGroupDocumentTemplate item group document template
       * @param \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate $contractDocumentTemplate contract document template (optional)
       */
      private function renderFormFields($itemGroupDocumentTemplate, $contractDocumentTemplate) {
        $contents = $itemGroupDocumentTemplate->getContents();
        $header = $itemGroupDocumentTemplate->getHeader();
        $footer = $itemGroupDocumentTemplate->getFooter();

        if (!$contractDocumentTemplate) {
          echo sprintf('<div class="notice-warning notice">%s</div>', __('Please not that saving this will create customized version of the contract document template', 'pakkasmarja_management'));
        } else {
          $contents = $contractDocumentTemplate->getContents();
          $header = $contractDocumentTemplate->getHeader();
          $footer = $contractDocumentTemplate->getFooter();
        }

        $this->renderRichInput(__('Contents', 'pakkasmarja_management'), "contents", $contents);
        $this->renderRichInput(__('Header', 'pakkasmarja_management'), "header", $header);
        $this->renderRichInput(__('Footer', 'pakkasmarja_management'), "footer", $footer);
      }

      /** 
       * Returns company name from contract
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $contract contract
       * @return String company name
       */
      private function getCompanyName($contract) {
        return Formatter::getCompanyName($contract->getContactId());
      }
      
      /**
       * Finds an contract document template
       *
       * @param string $contract contract (required)
       * @param string $itemGroupDocumentTemplate item group document template (required)
       *
       * @return \Metatavu\Pakkasmarja\Api\Model\ContractContractDocumentTemplate
       */
      private function findContractDocumentTemplate($contract, $itemGroupDocumentTemplate) {
        try {
          return array_shift($this->contractsApi->listContractDocumentTemplates($contract->getId(), $itemGroupDocumentTemplate->getType()));
        } catch (\Exception $e) {
          $message = $e->getMessage();
          error_log("Failed to find contract document template #$contractDocumentTemplateId: $message");
          return null;
        }
      }

      /**
       * Updates or creates contract document template. If no existing contract document template is provided new one is created
       * 
       * @param string $contractDocumentTemplate contract document template if exists
       * @param string $contractId contract id
       * @param string $type type
       * @param string $contents contents contents
       * @param string $header header header
       * @param string $footer footer footer
       */
      private function updateContractDocumentTemplate($contractDocumentTemplate, $contractId, $type, $contents, $header, $footer) {
        try {
          if (!$contractDocumentTemplate) {
            return $this->contractsApi->createContractDocumentTemplate($contractId, new \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate([
              'contractId' => $contractId,
              'type' => $type,
              'contents' => $contents,
              'header' => $header,
              'footer' => $footer
            ]));
          } else {
            $contractDocumentTemplate->setContents($contents);
            $contractDocumentTemplate->setHeader($header);
            $contractDocumentTemplate->setFooter($footer);
            return $this->contractsApi->updateContractDocumentTemplate($contractDocumentTemplate->getContractId(), $contractDocumentTemplate->getId(), $contractDocumentTemplate);
          }
        } catch (\Exception $e) {
          $message = $e->getMessage();
          error_log("Failed to find contract document template #$contractDocumentTemplateId: $message");
          return null;
        }
      }

    }
  }
  
  add_action('init', function () {
    if (is_admin()) {
      new ContractDocumentTemplateEditView();
    }
  });
    
?>