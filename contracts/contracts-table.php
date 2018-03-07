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
            "companyName" => Formatter::getCompanyName($contract["contactId"]),
            "status" => Formatter::formatContractStatus($contract["status"]),
            "itemGroupName" => Formatter::getItemGroupName($contract["itemGroupId"]),
            "contractQuantity" => $contract["contractQuantity"],
            "deliveredQuantity" => $contract["deliveredQuantity"],
            "placeName" => Formatter::getDeliveryPlaceName($contract["deliveryPlaceId"]),
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
        if ($which === "top" && current_user_can('pakkasmarja_contracts_view')) {
          if (current_user_can('pakkasmarja_contracts_view')) {
            $xlsxUrl = "?page=contract.php&action=xlsx";
            echo sprintf('<a class="button" style="display: inline-block; margin-left:-7px" href="%s">%s</a>', $xlsxUrl, __('Download XLSX', 'pakkasmarja_management'));
          }
        }
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
      public function column_companyName($item) {
        $id = $item['id'];
        $companyName = $item['companyName'];
        $editUrl = sprintf("?page=pakkasmarja-contract-edit-view.php&action=%s&id=%s", "edit", $id);
        $actions = [];
        $actions['edit'] = sprintf('<a href="%s">%s</a>', $editUrl, __('Edit', 'pakkasmarja_management'));
        return sprintf('%1$s%2$s', sprintf('<a href="%s">%s</a>', $editUrl, $companyName), $this->row_actions($actions));
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