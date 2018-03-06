<?php

  namespace Metatavu\Pakkasmarja\Contracts;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  use \Metatavu\Pakkasmarja\Utils\Formatter;

  if (!class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }
  
  require_once( __DIR__ . '/../api/api-client.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Contracts\ContractsTable' ) ) {
    
    /**
     * Contract reports table
     */
    class ContractsTable extends \WP_List_Table {

      private $perPage = 10;
      
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
      private $deliveryPlaceApi;

      /**
       * Constructor
       */
      public function __construct() {        
        parent::__construct([
          'singular'  => 'contract_report',
          'plural'    => 'contract_reports',
          'ajax'      => false  
        ]);
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-dialog', null, ['jquery']);
        wp_enqueue_script('contract-reports-table', plugin_dir_url(__FILE__) . 'contract-reports-table.js', null, ['jquery-ui-dialog' ]);
        
        wp_register_style('jquery-ui', 'https://cdn.metatavu.io/libs/jquery-ui/1.12.1/jquery-ui.min.css');
        wp_enqueue_style('jquery-ui');

        $this->contractsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi();
        $this->contactsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContactsApi();
        $this->itemGroupsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi();
        $this->deliveryPlaceApi = \Metatavu\Pakkasmarja\Api\ApiClient::getDeliveryPlacesApi();
      }
      
      /**
       * Prepares items
       */
      public function prepare_items() {
        $this->_column_headers = [ $this->get_columns(), $this->get_hidden_columns(), $this->get_sortable_columns() ];
        $this->process_bulk_action();
        $response = $this->listContracts($this->get_pagenum(), $this->perPage);

        $this->items = [];

        foreach ($response["items"] as $contract) {
          $this->items[] = [
            "id" => $contract["id"],
            "companyName" => $this->getCompanyName($contract["contactId"]),
            "status" => Formatter::formatContractStatus($contract["status"]),
            "itemGroupName" => $this->getItemGroupName($contract["itemGroupId"]),
            "contractQuantity" => $contract["contractQuantity"],
            "deliveredQuantity" => $contract["deliveredQuantity"],
            "placeName" =>  $this->getDeliveryPlaceName($contract["deliveryPlaceId"]),
            "remarks" => $contract["remarks"],
            "signDate" => Formatter::formatDateTime($contract["signDate"]),
            "startDate" => Formatter::formatDateTime($contract["startDate"]),
            "endDate" => Formatter::formatDateTime($contract["endDate"]),
            "approvalDate" => Formatter::formatDateTime($contract["termDate"])
          ];
        }

        $totalCount = empty($response["totalCount"]) ? 0 : intval($response["totalCount"]);
        
        $this->set_pagination_args([
          'total_items' => $totalCount,
          'per_page'    => $this->perPage,
          'total_pages' => ceil($totalCount / $this->perPage)
        ]);
      }

      /**
       * Renders actions bar into the table
       * @param string $which which bar is in question (top or bottom)
       */
      public function extra_tablenav($which) {
        
      }
       
      /**
       * Returns columns
       * 
       * @return array columns
       */
      public function get_columns() {
        $columns = [
          'id' => 'ID',
          "companyName" => __('Company', 'pakkasmarja_management'),
          'status' => __('Status', 'pakkasmarja_management'),
          "itemGroupName" => __('Item Group', 'pakkasmarja_management'),
          "contractQuantity" => __('Contract Quantity', 'pakkasmarja_management'),
          "deliveredQuantity" => __('Delivered Quantity', 'pakkasmarja_management'),
          "placeName" =>__('Place', 'pakkasmarja_management'),
          "remarks" =>__('Remarks', 'pakkasmarja_management'),
          "signDate" =>__('Sign date', 'pakkasmarja_management'),
          "startDate" => __('Start date', 'pakkasmarja_management'),
          "endDate" => __('End date', 'pakkasmarja_management'),
          "approvalDate" => __('Approval date', 'pakkasmarja_management'),
        ];

        return $columns;
      }

      /**
       * Returns hidden columns
       * @return array hidden columns
       */
      public function get_hidden_columns() {
        return ['id'];
      }
      
      /**
       * Returns sortable columns
       * @return array sortable columns
       */
      public function get_sortable_columns() {
        return [ ];
      }
      
      /**
       * Renders default column
       * 
       * @param $item array item data
       * @param $columnName column's name
       * @return rendered column  
       */
      public function column_default( $item, $columnName) {
        return $item[$columnName];
      }
      
      /**
       * Renders type column
       * 
       * @param $item array item data
       * @return rendered type column  
       */
      public function column_type($item) {
        // TODO: companyName

        $id = $item['id'];
        $type = $item['type'];
        $viewUrl = sprintf("?page=pakkasmarja-contract-report-view.php&action=%s&id=%s", "view", $id);
        $actions = [];
        $actions['view'] = sprintf('<a href="%s">%s</a>', $viewUrl, __('View', 'pakkasmarja_management'));
        return sprintf('%1$s%2$s', sprintf('<a href="%s">%s</a>', $viewUrl, $type), $this->row_actions($actions));
      }

      /**
       * Resolves company name by contact id
       * 
       * @param string $contactId contactId
       * @return string contact's company name
       */
      private function getCompanyName($contactId) {
        $contact = $this->findContactById($contactId);
        if ($contact) {
          return $contact->getCompanyName();
        }

        return null;
      }

      /**
       * Resolves item group name by item group id
       * 
       * @param string $itemGroupId item group id
       * @return string item group name
       */
      private function getItemGroupName($itemGroupId) {
        $itemGroup = $this->findItemGroupById($itemGroupId);
        if ($itemGroup) {
          return $itemGroup->getName();
        }

        return null;
      }

      /**
       * Resolves delivery place name by delivery place id
       * 
       * @param string $deliveryPlaceId delivery place id
       * @return string delivery place name
       */
      private function getDeliveryPlaceName($deliveryPlaceId) {
        $deliveryPlace = $this->findDeliveryPlaceById($deliveryPlaceId);
        if ($deliveryPlace) {
          return $deliveryPlace->getName();
        }

        return null;
      }

      /**
       * Finds an item group by id
       *
       * @param string $itemGroupId item group id (required)
       *
       * @return \Metatavu\Pakkasmarja\Api\Model\ItemGroup
       */
      private function findItemGroupById($itemGroupId) {
        try {
          return $this->itemGroupsApi->findItemGroup($itemGroupId);
        } catch (\Metatavu\Pakkasmarja\ApiException | \InvalidArgumentException $e) {
          $message = $e->getMessage();
          error_log("Failed to find item group #$itemGroupId: $message");
          return null;
        }
      }

      /**
       * Finds a contact by id
       *
       * @param string $contactId contact id (required)
       *
       * @return \Metatavu\Pakkasmarja\Api\Model\Contact
       */
      private function findContactById($contactId) {
        try {
          return $this->contactsApi->findContact($contactId);
        } catch (\Metatavu\Pakkasmarja\ApiException | \InvalidArgumentException $e) {
          $message = $e->getMessage();
          error_log("Failed to find contact #$contactId: $message");
          return null;
        }
      }

      /**
       * Finds a delivery place by id
       *
       * @param string $deliveryPlaceId delivery place id (required)
       *
       * @return \Metatavu\Pakkasmarja\Api\Model\DeliveryPlace
       */
      private function findDeliveryPlaceById($deliveryPlaceId) {
        try {
          return $this->deliveryPlaceApi->findDeliveryPlace($deliveryPlaceId);
        } catch (\Metatavu\Pakkasmarja\ApiException | \InvalidArgumentException $e) {
          $message = $e->getMessage();
          error_log("Failed to find delivery place #$deliveryPlaceId: $message");
          return null;
        }
      }

      /**
       * Lists contract reports
       * 
       * @param int $page page number
       * @param int $pageSize items per page
       * @return array associative array containing items and pageCount  
       */
      private function listContracts($page, $pageSize) {
        $type = null;
        $sortBy = null;
        $sortDir = null;
        $firstResult = ($page - 1) * $pageSize;
        $maxResults = $pageSize;

        try {
          $result = $this->contractsApi->listContractsWithHttpInfo($type, $sortBy, $sortDir, $firstResult, $maxResults);
          $headers = $result[2];
          $totalCountHeader = $headers["Total-Count"];
          $totalCount = is_array($totalCountHeader) ? $totalCountHeader[0] : null;
          return [
            "items" => $result[0],
            "totalCount" => $totalCount
          ];
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
    
?>