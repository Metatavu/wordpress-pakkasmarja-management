<?php

  namespace Metatavu\Pakkasmarja\Operations;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }
  
  require_once( __DIR__ . '/../api/api-client.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Operations\OperationsReportTable' ) ) {
    
    /**
     * Operation reports table
     */
    class OperationReportsTable extends \WP_List_Table {
      
      private static $DEFAULT_TIMEZONE = 'Europe/Helsinki';
      private static $DATE_FORMAT = 'Y-m-d';
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
            "type" => $this->getTypeLabel($operationReport['type']),
            "started" => $this->formatDateTime($operationReport["started"]),
            "status" => $this->getStatus($operationReport["pendingCount"], $operationReport["failedCount"], $operationReport["successCount"])
          ];
        }
        
        $this->set_pagination_args([
          'total_items' => $response["pageCount"],
          'per_page'    => $this->perPage,
          'total_pages' => ceil($itemCount/ $this->perPage)
        ]);
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
        $viewUrl = sprintf("?page=operation-report.php&action=%s&id=%s", "view", $id);
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
          return __('In Progress', 'pakkasmarja_management');
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
      private function getTypeLabel($type) {
        switch ($type) {
          case "SAP_CONTACT_SYNC":
            return __('SAP Contacts', 'pakkasmarja_management');
          case "SAP_DELIVERY_PLACE_SYNC":
            return __('SAP Delivery Places', 'pakkasmarja_management');
          case "SAP_ITEM_GROUP_SYNC":
            return __('SAP Item Groups', 'pakkasmarja_management');
          case "SAP_CONTRACT_SYNC":
            return __('SAP Contracts', 'pakkasmarja_management');
        }
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
          // TODO: Page count
          return [
            "items" => $result[0],
            "pageCount" => 10
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
      
      /**
       * Returns date time as string
       * 
       * @param \DateTime $dateTime date time
       * @return string formatted date time
       */
      private function formatDateTime($dateTime) {
        if ($dateTime) {
          $clone = clone $dateTime;
          $clone->setTimezone($this->getTimezone());
          return $clone->format(self::$DATE_FORMAT);
        }
        
        return null;
      }
      
      /**
       * Returns time zone
       * 
       * @return \DateTimeZone time zone
       */
      private function getTimezone() {
        return new \DateTimeZone($result ? $result : self::$DEFAULT_TIMEZONE);
      }
      
    }
    
  }
    
?>