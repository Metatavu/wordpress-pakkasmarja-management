<?php
  
  namespace Metatavu\Pakkasmarja\Contracts;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  use \Metatavu\Pakkasmarja\Utils\Formatter;
  
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../utils/formatter.php');
  require_once( __DIR__ . '/../utils/abstract-edit-view.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Contracts\ContractEditView' ) ) {
    
    class ContractEditView extends \Metatavu\Pakkasmarja\Utils\AbstractEditView {

      private $capability = 'pakkasmarja_contracts_edit';
           
      /**
       * @var \Metatavu\Pakkasmarja\Api\ContractsApi
       */
      private $contractsApi;

      /**
       * @var \Metatavu\Pakkasmarja\Api\ContactsApi
       */
      private $contactsApi;
      
      /**
       * @var \Metatavu\Pakkasmarja\Api\ItemGroupsApi
       */
      private $itemGroupsApi;

      /**
       * @var \Metatavu\Pakkasmarja\Api\DeliveryPlacesApi
       */
      private $deliveryPlacesApi;
      
      /**
       * Constructorr
       */
      public function __construct() {
        parent::__construct();
        
        $this->contractsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi();
        $this->contactsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContactsApi();
        $this->itemGroupsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi();
        $this->deliveryPlacesApi = \Metatavu\Pakkasmarja\Api\ApiClient::getDeliveryPlacesApi();
        
        add_action( 'admin_menu', function () {
          add_submenu_page(NULL, __('Edit Contract', 'pakkasmarja_management'), __('Edit Contract', 'pakkasmarja_management'), $this->capability, 'pakkasmarja-contract-edit-view.php', [ $this, 'renderContractEditView' ]);
        });
      }

      /**
       * Renders contract report view
       */
      public function renderContractEditView() {
        $id = sanitize_text_field($_GET['id']);
        $contract = $this->findContractById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $validateMessage = $this->validatePost();
          if ($validateMessage) {
            echo '<div class="notice-error notice">' . $validateMessage . '</div>';
          } else {
            $contractQuantity = $this->getPostInt("contract-quantity");
            $status = $this->getPostString("status");
            $deliveryPlaceId = $this->getPostString("delivery-place");
            $remarks = $this->getMemoPostString("remarks");
            
            if (!$this->updateContract($contract, $contractQuantity, $status, $deliveryPlaceId, $remarks)) {
              echo sprintf('<div class="notice-error notice">%s</div>', htmlspecialchars(__('Failed to update contract', 'pakkasmarja_management')));
            }
          }
        }

        wp_enqueue_style('pakkasmarja-forms', plugin_dir_url(__FILE__) . '../forms.css');

        echo '<div class="wrap">';
        $backLink = sprintf('<a href="%s" class="page-title-action">%s</a>', "?page=contract.php", __('Back', 'pakkasmarja_management'));
        echo sprintf('<h1 class="wp-heading-inline">%s - %s %s</h1><br/><br/>', $this->getCompanyName($contract), $this->getItemGroupName($contract), $backLink);
        echo '<hr class="wp-header-end"/>';

        $this->renderForm($contract);

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
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $contract contract
       */
      private function renderForm($contract) {
        $this->renderContractFormStart($contract);
        $this->renderFormFields($contract);
        $this->renderFormEnd();
      }
      
      /**
       * Renders contract form start
       */
      private function renderContractFormStart($contract) {
        $action = sprintf('admin.php?page=pakkasmarja-contract-edit-view.php&action=edit&id=%s', $contract->getId());
        $this->renderFormStart($action);
      }

      /**
       * Renders contract form fields
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      private function renderFormFields($contract) {
        $this->renderNumberInput(__('Contract Quantity', 'pakkasmarja_management'), "contract-quantity", $contract->getContractQuantity());
        $this->renderStatusInput(__('Status', 'pakkasmarja_management'), "status", $contract->getStatus());
        $this->renderDeliveryPlaceInput(__('Delivery Place', 'pakkasmarja_management'), "delivery-place", $contract->getDeliveryPlaceId());
        $this->renderMemoInput(__('Remarks', 'pakkasmarja_management'), "remarks", $contract->getRemarks());
      }

      /**
       * Renders a contract status dropdown input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      private function renderStatusInput($label, $name, $value) {
        $statuses = ["APPROVED", "ON_HOLD", "DRAFT", "TERMINATED"];
        $options = [];
        
        foreach ($statuses as $status) {
          $text = Formatter::formatContractStatus($status);
          $options[$status] = $text;
        }

        $this->renderDropdownInput($label, $name, $value, $options);
      }

      /**
       * Renders a delivery places dropdown input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      private function renderDeliveryPlaceInput($label, $name, $value) {
        $options = [];
        
        foreach ($this->listDeliveryPlaces() as $deliveryPlace) {
          $options[$deliveryPlace->getId()] = $deliveryPlace->getName();
        }

        $this->renderDropdownInput($label, $name, $value, $options);
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
       * Returns item group name from contract
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $contract contract
       * @return String item group name
       */
      private function getItemGroupName($contract) {
        return Formatter::getItemGroupName($contract->getItemGroupId());
      }

      /**
       * Updates contract
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $contract contract
       * @param int $contractQuantity new contract quantity
       * @param String $status new status
       * @param String $deliveryPlaceId new delivery place id
       * @param String $remarks remark
       * @return \Metatavu\Pakkasmarja\Api\Model\Contract updated contract
       */
      private function updateContract($contract, $contractQuantity, $status, $deliveryPlaceId, $remarks) {
        try {
          $contract->setContractQuantity($contractQuantity);
          $contract->setStatus($status);
          $contract->setDeliveryPlaceId($deliveryPlaceId);
          $contract->setRemarks($remarks);
          return $this->contractsApi->updateContract($contract->getId(), $contract);
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
       * Lists delivery places
       * 
       * @return array array containing delivery places  
       */
      private function listDeliveryPlaces() {
        try {
          return $this->deliveryPlacesApi->listDeliveryPlaces();
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

    }
  }
  
  add_action('init', function () {
    if (is_admin()) {
      new ContractEditView();
    }
  });
    
?>