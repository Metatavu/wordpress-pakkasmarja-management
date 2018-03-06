<?php

  namespace Metatavu\Pakkasmarja\Operations;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  use \Metatavu\Pakkasmarja\Utils\Formatter;
  
  if (!class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }
  
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../utils/formatter.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Operations\OperationsReportTable' ) ) {
    
    /**
     * Operation reports table
     */
    class OperationReportsTable extends \WP_List_Table {

      private static $SUPPORTED_OPERATION_TYPES = ["SAP_CONTACT_SYNC", "SAP_DELIVERY_PLACE_SYNC", "SAP_ITEM_GROUP_SYNC", "SAP_CONTRACT_SYNC"]; 
      private $perPage = 10;
      
      /**
       * @var \Metatavu\Pakkasmarja\Api\OperationReportsApi
       */
      private $operationReportsApi;
      
      /**
       * Constructor
       */
      public function __construct() {        
        parent::__construct([
          'singular'  => 'operation_report',
          'plural'    => 'operation_reports',
          'ajax'      => false  
        ]);
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-dialog', null, ['jquery']);
        wp_enqueue_script('operation-reports-table', plugin_dir_url(__FILE__) . 'operation-reports-table.js', null, ['jquery-ui-dialog' ]);
        
        wp_register_style('jquery-ui', 'https://cdn.metatavu.io/libs/jquery-ui/1.12.1/jquery-ui.min.css');
        wp_enqueue_style('jquery-ui');

        $this->operationReportsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getOperationReportsApi();
      }
      
      /**
       * Prepares items
       */
      public function prepare_items() {
        $this->_column_headers = [ $this->get_columns(), $this->get_hidden_columns(), $this->get_sortable_columns() ];
        $this->process_bulk_action();
        $response = $this->listOperationReports($this->get_pagenum(), $this->perPage);

        $this->items = [];
        
        foreach ($response["items"] as $operationReport) {
          $this->items[] = [
            "id" => $operationReport['id'],
            "type" => $this->getOperationTypeLabel($operationReport['type']),
            "started" => Formatter::formatDateTime($operationReport["started"]),
            "status" => $this->getStatus($operationReport["pendingCount"], $operationReport["failedCount"], $operationReport["successCount"])
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
        if ($which === "top" && current_user_can('pakkasmarja_operations_create')) {
          echo sprintf("<label>%s</label>", __('Operation', 'pakkasmarja_management'));
          echo "\n";
          echo '<select name="operation-type">';
          
          foreach (self::$SUPPORTED_OPERATION_TYPES as $operationType) {
            echo sprintf('<option value="%s">%s</option>', $operationType, Formatter::formatOperationType($operationType));
          }

          echo "</select>";
          echo "\n";
          
          echo sprintf('<button id="doaction" class="button" data-dialog-confirm="%s" data-dialog-cancel="%s" data-dialog-title="%s" data-dialog-content="%s">%s</button>', 
            htmlspecialchars(__('Confirm', 'pakkasmarja_management')),
            htmlspecialchars(__('Cancel', 'pakkasmarja_management')),
            htmlspecialchars(__('Confirm operation', 'pakkasmarja_management')),
            htmlspecialchars(__('Confirm operation %s start', 'pakkasmarja_management')),
            htmlspecialchars(__('Start', 'pakkasmarja_management'))
          );
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
          'type' => __('Type', 'pakkasmarja_management'),
          'started' => __('Started', 'pakkasmarja_management'),
          'status' => __('Status', 'pakkasmarja_management')
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
        $id = $item['id'];
        $type = $item['type'];
        $viewUrl = sprintf("?page=pakkasmarja-operation-report-view.php&action=%s&id=%s", "view", $id);
        $actions = [];
        $actions['view'] = sprintf('<a href="%s">%s</a>', $viewUrl, __('View', 'pakkasmarja_management'));
        return sprintf('%1$s%2$s', sprintf('<a href="%s">%s</a>', $viewUrl, $type), $this->row_actions($actions));
      }

      /**
       * Returns status based on task counts
       * 
       * @param int $pendingCount count of pending tasks
       * @param int $failedCount count of failed count tasks
       * @param int $successCount count of succesfull tasks 
       * @return string status based on task counts
       */
      private function getStatus($pendingCount, $failedCount, $successCount) {
        if ($pendingCount > 0) {
          return sprintf(__('In Progress (%d / %d)', 'pakkasmarja_management'), $failedCount + $successCount, $pendingCount);
        }

        if ($successCount > 0 && $failedCount > 0) {
          return sprintf(__('Contains Errors (%d / %d)', 'pakkasmarja_management'), $successCount, $failedCount);
        }

        if ($successCount === 0 && $failedCount > 0) {
          return __('Errored', 'pakkasmarja_management');
        }

        return __('Success', 'pakkasmarja_management');
      }

      /**
       * Returns localized type
       * 
       * @param string $type type
       * @return string localized type
       */
      private function getOperationTypeLabel($type) {
        return Formatter::formatOperationType($type);
      }

      /**
       * Lists operation reports
       * 
       * @param int $page page number
       * @param int $pageSize items per page
       * @return array associative array containing items and pageCount  
       */
      private function listOperationReports($page, $pageSize) {
        $type = null;
        $sortBy = null;
        $sortDir = null;
        $firstResult = ($page - 1) * $pageSize;
        $maxResults = $pageSize;

        try {
          $result = $this->operationReportsApi->listOperationReportsWithHttpInfo($type, $sortBy, $sortDir, $firstResult, $maxResults);
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