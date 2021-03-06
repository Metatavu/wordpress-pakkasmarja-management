<?php
  
  namespace Metatavu\Pakkasmarja\Contracts;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  use \Metatavu\Pakkasmarja\Utils\Formatter;
  
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../utils/formatter.php');
  require_once( __DIR__ . '/../utils/abstract-edit-view.php');
  require_once( __DIR__ . '/../utils/consts.php');
  
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

        add_action( 'wp_ajax_pakkasmarja_search_contacts', [ $this, 'ajaxSearchContacts'] );
      }

      /**
       * Renders contract report view
       */
      public function renderContractEditView() {
        $id = sanitize_text_field($_GET['id']);
        $contract = $id !== 'NEW' ? $this->findContractById($id) : null;

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-autocomplete', null, ['jquery']);
        wp_enqueue_script('contracts-edit-view', plugin_dir_url(__FILE__) . 'contracts-edit-view.js', null, ['jquery-ui-autocomplete' ]);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $validateMessage = $this->validatePost();
          if ($validateMessage) {
            echo '<div class="notice-error notice">' . $validateMessage . '</div>';
          } else {
            $contractQuantity = $this->getPostInt("contract-quantity");
            $status = $this->getPostString("status");
            $deliveryPlaceId = $this->getPostString("delivery-place");
            $remarks = $this->getMemoPostString("remarks");
            $quantityComment = $this->getMemoPostString("quantity-comment");
            $deliveryPlaceComment = $this->getMemoPostString("delivery-place-comment");
            $deliverAll = "true" == $this->getMemoPostString("deliver-all");
            $sapId = $this->getPostString("sap-id");

            if ($id === 'NEW') {
              $contactId = $this->getPostString("contact-id");
              $itemGroupId = $this->getPostString("item-group-id");
              $contract = $this->createContract($contactId, $sapId, $itemGroupId, $contractQuantity, $status, $deliveryPlaceId, $remarks, $quantityComment, $deliveryPlaceComment);
              
              if (!$contract) {
                echo sprintf('<div class="notice-error notice">%s</div>', htmlspecialchars(__('Failed to create contract', 'pakkasmarja_management')));
              } else {
                $id = $contract->getId();
              }
            } else {
              if (!$this->updateContract($contract, $sapId, $contractQuantity, $status, $deliveryPlaceId, $remarks, $quantityComment, $deliveryPlaceComment, $deliverAll)) {
                echo sprintf('<div class="notice-error notice">%s</div>', htmlspecialchars(__('Failed to update contract', 'pakkasmarja_management')));
              }
            }
          }
        }

        wp_enqueue_style('pakkasmarja-forms', plugin_dir_url(__FILE__) . '../forms.css');

        echo '<div class="wrap">';
        $backLink = sprintf('<a href="%s" class="page-title-action">%s</a>', "?page=contract.php", __('Back', 'pakkasmarja_management'));

        if ($contract) {
          echo sprintf('<h1 class="wp-heading-inline">%s - %s %s</h1><br/><br/>', $this->getCompanyName($contract), $this->getItemGroupName($contract), $backLink);
        } else {
          echo sprintf('<h1 class="wp-heading-inline">%s %s</h1><br/><br/>', __('New Contract', 'pakkasmarja_management'), $backLink);
        }

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
        $action = sprintf('admin.php?page=pakkasmarja-contract-edit-view.php&action=edit&id=%s', $contract ? $contract->getId() : 'NEW');
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
        if (!$contract) {
          $this->renderContactInput(__('Contact', 'pakkasmarja_management'), "contact-id");
          $this->renderItemGroupInput(__('Item Group', 'pakkasmarja_management'), "item-group-id");
        }

        $this->renderTextInput(__('SAP Id', 'pakkasmarja_management'), "sap-id", $contract ? $contract->getSapId() : "");
        $this->renderStatusInput(__('Status', 'pakkasmarja_management'), "status", $contract ? $contract->getStatus() : "DRAFT");
        $this->renderInlineTextField(__('Reject Comment', 'pakkasmarja_management'), $contract ? $contract->getRejectComment() : null);
        $this->renderLine();
        $this->renderInlineTextField(__('Proposed Quantity', 'pakkasmarja_management'), $contract ? $contract->getProposedQuantity() : null);
        $this->renderMemoInput(__('Quantity Comment', 'pakkasmarja_management'), "quantity-comment", $contract ? $contract->getQuantityComment() : null);
        $this->renderNumberInput(__('Contract Quantity', 'pakkasmarja_management'), "contract-quantity", $contract ? $contract->getContractQuantity() : "0");

        $this->renderDeliverAllInput($contract ? $contract->getDeliverAll() : false);
        echo sprintf('<p style="font-size: 18px">Viljelijän ehdotus: %s</p>', ($contract ? $contract->getProposedDeliverAll() : false) ? "Kyllä" : "Ei");

        $this->renderDeliveryPlaceInput(__('Delivery Place', 'pakkasmarja_management'), "delivery-place", $contract ? $contract->getDeliveryPlaceId() : null);
        $this->renderInlineTextField(__('Proposed Delivery Place', 'pakkasmarja_management'), $contract ? Formatter::getDeliveryPlaceName($contract->getProposedDeliveryPlaceId()) : null);        
        $this->renderMemoInput(__('Delivery Place Comment', 'pakkasmarja_management'), "delivery-place-comment", $contract ? $contract->getDeliveryPlaceComment() : null);
        $this->renderLine();
        $this->renderMemoInput(__('Remarks (SAP)', 'pakkasmarja_management'), "remarks", $contract ? $contract->getRemarks() : null);
      }

      /**
       * Renders a contract status dropdown input
       * 
       * @param String $label input label
       * @param String $name input name
       * @param String $value input value
       */
      private function renderStatusInput($label, $name, $value) {
        $statuses = \Metatavu\Pakkasmarja\Utils\Consts::CONTRACT_STATUSES;
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
       * Renders a contact autocomplete input
       * 
       * @param String $label input label
       * @param String $name input name
       */
      private function renderContactInput($label, $name) {
        echo '<input type="hidden" name="' . $name . '"/>';
        $this->renderTextInput($label, "$name-ac", null);
      }

      /**
       * Renders a deliver all dropdown input
       * 
       * @param Boolean $value value
       */
      private function renderDeliverAllInput($value) {
        $options = [];
        $options["true"] = "Kyllä";
        $options["false"] = "Ei";

        $this->renderDropdownInput(__('Farmed delivers all berries to company', 'pakkasmarja_management'), "deliver-all",  $value ? "true" : "false", $options);
      }

      /**
       * Renders a item group dropdown input
       * 
       * @param String $label input label
       * @param String $name input name
       */
      private function renderItemGroupInput($label, $name) {
        $options = [];
        
        foreach ($this->listItemGroups() as $itemGroup) {
          $options[$itemGroup->getId()] = Formatter::getItemGroupName($itemGroup->getId());
        }

        $this->renderDropdownInput($label, $name, null, $options);
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
       * Ajax action for searching contacts
       */
      public function ajaxSearchContacts() {
        try {
          $searchResults = $this->listContacts($_POST['search']);
          $result = [];
          
          foreach ($searchResults as $searchResult) {
            $companyName = Formatter::getCompanyName($searchResult->getId());

            $result[] = [
              'value' => $companyName,
              'id' => $searchResult->getId()
            ];
          }

          echo json_encode($result);

          wp_die();
        } catch (\Metatavu\Pakkasmarja\ApiException $e) {
          $message = json_encode($e->getResponseBody());
          wp_die($message, null, [
            response => $e->getCode()
          ]);
        }
      }

      /**
       * Creates a contract
       * 
       * @param String $contactId contact id
       * @param STring $sapId SAP id
       * @param String $itemGroupId item group id
       * @param int $contractQuantity new contract quantity
       * @param String $status new status
       * @param String $deliveryPlaceId new delivery place id
       * @param String $remarks remark
       * @param String $quantityComment quantity comment
       * @param String $deliveryPlaceComment delivery place comment
       * @return \Metatavu\Pakkasmarja\Api\Model\Contract updated contract
       */
      private function createContract($contactId, $sapId, $itemGroupId, $contractQuantity, $status, $deliveryPlaceId, $remarks, $quantityComment, $deliveryPlaceComment) {
        try {
          $contract = new \Metatavu\Pakkasmarja\Api\Model\Contract();

          $contract->setContactId($contactId);
          $contract->setSapId($sapId);
          $contract->setItemGroupId($itemGroupId);
          $contract->setContractQuantity($contractQuantity);
          $contract->setProposedQuantity($contractQuantity);
          $contract->setStatus($status);
          $contract->setDeliveryPlaceId($deliveryPlaceId);
          $contract->setProposedDeliveryPlaceId($deliveryPlaceId);
          $contract->setRemarks($remarks);
          $contract->setQuantityComment($quantityComment);
          $contract->setDeliveryPlaceComment($deliveryPlaceComment);
          $contract->setYear(date("Y"));
          $contract->setDeliverAll(false);
          $contract->setProposedDeliverAll(false);
          $contract->setAreaDetails([]);

          return $this->contractsApi->createContract($contract);
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
       * Updates contract
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\Contract $contract contract
       * @param STring $sapId SAP id
       * @param int $contractQuantity new contract quantity
       * @param String $status new status
       * @param String $deliveryPlaceId new delivery place id
       * @param String $remarks remark
       * @param String $quantityComment quantity comment
       * @param String $deliveryPlaceComment delivery place comment
       * @param boolean $deliverAll
       * @return \Metatavu\Pakkasmarja\Api\Model\Contract updated contract
       */
      private function updateContract($contract, $sapId, $contractQuantity, $status, $deliveryPlaceId, $remarks, $quantityComment, $deliveryPlaceComment, $deliverAll) {
        try {
          $contract->setSapId($sapId);
          $contract->setContractQuantity($contractQuantity);
          $contract->setStatus($status);
          $contract->setDeliveryPlaceId($deliveryPlaceId);
          $contract->setRemarks($remarks);
          $contract->setQuantityComment($quantityComment);
          $contract->setDeliveryPlaceComment($deliveryPlaceComment);
          $contract->setDeliverAll($deliverAll);
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

      /**
       * Lists contacts
       * 
       * @return array array containing contacts
       */
      private function listContacts($search) {
        try {
          return $this->contactsApi->listContacts($search);
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
       * Lists item groups
       * 
       * @return array array containing item groups
       */
      private function listItemGroups() {
        try {
          return $this->itemGroupsApi->listItemGroups();
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