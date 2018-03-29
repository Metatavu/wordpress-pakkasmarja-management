<?php

  namespace Metatavu\Pakkasmarja\Contracts;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  use \Metatavu\Pakkasmarja\Utils\Formatter;
  use \Metatavu\Pakkasmarja\Utils\Consts;

  if (!class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }
  
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../utils/consts.php');

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
       * @var \Metatavu\Pakkasmarja\Api\Model\ItemGroup[]
       */
      private $itemGroups;

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
        wp_enqueue_script('contracts-table', plugin_dir_url(__FILE__) . 'contracts-table.js', null, ['jquery-ui-dialog' ]);
        
        wp_register_style('jquery-ui', 'https://cdn.metatavu.io/libs/jquery-ui/1.12.1/jquery-ui.min.css');
        wp_enqueue_style('jquery-ui');

        $this->contractsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi();
        $this->contactsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getContactsApi();
        $this->itemGroupsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi();
        $this->deliveryPlaceApi = \Metatavu\Pakkasmarja\Api\ApiClient::getDeliveryPlacesApi();

        $this->itemGroups = $this->itemGroupsApi->listItemGroups();
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
            "itemGroupId" => $contract["itemGroupId"],
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
      protected function extra_tablenav($which) {
        if ($which === "top") {
          $selectedItemGroup = sanitize_text_field($_REQUEST["item-group-id"]);
          $itemGroupOptions = [];
          foreach ($this->itemGroups as $itemGroup) {
            $text = $itemGroup->getDisplayName();
            if (!$text) {
              $text = $itemGroup->getName();
            }

            $itemGroupOptions[] = [
              "value" => $itemGroup->getId(),
              "text" => $text,
              "selected" => $selectedItemGroup === $itemGroup->getId()
            ];
          }

          $this->printExtraNavSelect("item-group-select", __('Show item group', 'pakkasmarja_management'), "item-group-id", $itemGroupOptions);

          $statusOptions = [];
          $selectedStatus = sanitize_text_field($_REQUEST["status"]); 
          $statuses = Consts::CONTRACT_STATUSES;
          foreach ($statuses as $status) {
            $text = Formatter::formatContractStatus($status);
            $statusOptions[] = [
              "value" => $status,
              "text" => $text,
              "selected" => $selectedStatus === $status
            ];
          }

          $this->printExtraNavSelect("status-select", __('Show status', 'pakkasmarja_management'), "status", $statusOptions);

          $yearOptions = [];
          $currentYear = intval(date("Y"));
          $selectedYear = intval(sanitize_text_field($_REQUEST["year"])); 

          for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
            $yearOptions[] = [
              "value" => $year,
              "text" => $year,
              "selected" => $selectedYear === $year
            ];
          };

          $this->printExtraNavSelect("year-select", __('Show year', 'pakkasmarja_management'), "year", $yearOptions);

          $xlsxUrl = "?page=contract.php&action=xlsx";
          echo sprintf('<a class="button" style="display: inline-block; href="%s">%s</a>', $xlsxUrl, __('Download XLSX', 'pakkasmarja_management'));
        }
      }

      /**
       * Prints a select field into extra nav section
       * 
       * @param String $name field name
       * @param String $label field label
       * @param Array[] $selectOptions field options
       */
      private function printExtraNavSelect($name, $label, $variable, $selectOptions) {
        echo '<div style="display:inline-block; vertical-align: text-top; margin-right:5px">';
        echo sprintf('<label for="%s">%s</label>', $name, $label);
        
        echo sprintf('<select id="%s" data-variable="%s" class="table-nav-query-select">', $name, $variable);
        foreach ($selectOptions as $option) {
          echo sprintf('<option value="%s"%s>%s</option>', $option['value'], $option['selected'] ? ' selected=selected' : '', $option['text']);
        }
        echo "</select>";

        echo '</div>';
      }
       
      /**
       * Returns columns
       * 
       * @return array columns
       */
      public function get_columns() {
        $columns = [
          'id' => 'ID',
          'itemGroupId' => 'itemGroupId',
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
        return ['id', 'itemGroupId'];
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
        $itemGroupId = $item['itemGroupId'];
        $actions = [];

        $companyName = $item['companyName'];
        $editUrl = sprintf("?page=pakkasmarja-contract-edit-view.php&action=%s&id=%s", "edit", $id);
        $actions['edit'] = sprintf('<a href="%s">%s</a>', $editUrl, __('Edit', 'pakkasmarja_management'));

        $itemGroupDocumentTemplates = $this->itemGroupsApi->listItemGroupDocumentTemplates($itemGroupId);
        foreach ($itemGroupDocumentTemplates as $itemGroupDocumentTemplate) {
          $pdfUrl = sprintf("?page=contract.php&action=%s&id=%s&type=%s", "single-pdf", $id, $itemGroupDocumentTemplate->getType());
          $editDocumentTemplateUrl = sprintf("?page=pakkasmarja-contracts-document-template-edit-view.php&item-group-document-template-id=%s&item-group-id=%s&contract-id=%s", $itemGroupDocumentTemplate->getId(), $itemGroupDocumentTemplate->getItemGroupId(), $id);
          $actions['edit-document-template-' . $itemGroupDocumentTemplate->getId()] = sprintf('<a href="%s">%s</a>', $editDocumentTemplateUrl, sprintf(__('Customize (%s)', 'pakkasmarja_management'), Formatter::formatDocumentTemplateType($itemGroupDocumentTemplate->getType())));
          $actions['pdf-' . $itemGroupDocumentTemplate->getId()] = sprintf('<a href="%s">%s</a>', $pdfUrl, sprintf(__('Preview (%s)', 'pakkasmarja_management'), Formatter::formatDocumentTemplateType($itemGroupDocumentTemplate->getType())));
        }

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
        $firstResult = ($page - 1) * $pageSize;
        $maxResults = $pageSize;
        $accept = null;
        $listAll = "true";
        $itemGroupCategory = null;
        $itemGroupId = sanitize_text_field($_REQUEST["item-group-id"]);
        $year = sanitize_text_field($_REQUEST["year"]);
        $status = sanitize_text_field($_REQUEST["status"]);

        if (!$itemGroupId) {
          $itemGroupId = $this->itemGroups[0]->getId();
        }

        if (!$year) {
          $year = intval(date("Y"));
        }

        try {
          $result = $this->contractsApi->listContractsWithHttpInfo($accept, $listAll, $itemGroupCategory, $itemGroupId, $year, $status, $firstResult, $maxResults);
            
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