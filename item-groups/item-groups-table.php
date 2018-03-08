<?php

  namespace Metatavu\Pakkasmarja\ItemGroups;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  use \Metatavu\Pakkasmarja\Utils\Formatter;

  if (!class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }
  
  require_once( __DIR__ . '/../api/api-client.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\ItemGroups\ItemGroupsTable' ) ) {
    
    /**
     * ItemGroup reports table
     */
    class ItemGroupsTable extends \WP_List_Table {

      private $perPage = 10;
      
      /**
       * @var \Metatavu\Pakkasmarja\Api\ItemGroupsApi
       */
      private $itemGroupsApi;

      /**
       * Constructor
       */
      public function __construct() {        
        parent::__construct([
          'singular'  => 'item-group',
          'plural'    => 'item-groups',
          'ajax'      => false  
        ]);
        
        $this->itemGroupsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi();
      }
      
      /**
       * Prepares items
       */
      public function prepare_items() {
        $this->_column_headers = [ $this->get_columns(), $this->get_hidden_columns(), $this->get_sortable_columns() ];
        $this->process_bulk_action();
        $response = $this->listItemGroups($this->get_pagenum(), $this->perPage);

        $this->items = [];

        foreach ($response["items"] as $itemGroup) {
          $this->items[] = [
            "id" => $itemGroup["id"],
            "name" => $itemGroup->getName()
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
       * Returns columns
       * 
       * @return array columns
       */
      public function get_columns() {
        $columns = [
          'id' => 'ID',
          "name" => __('Name', 'pakkasmarja_management')
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
      public function column_name($item) {
        $id = $item['id'];
        $name = $item['name'];

        $actions = [];

        $itemGroupDocumentTemplates = $this->itemGroupsApi->listItemGroupDocumentTemplates($id);
        foreach ($itemGroupDocumentTemplates as $itemGroupDocumentTemplate) {
          $editUrl = sprintf("?page=pakkasmarja-item-group-document-template-edit-view.php&item-group-id=%s&id=%s", $itemGroupDocumentTemplate->getItemGroupId(), $itemGroupDocumentTemplate->getId());
          $title = sprintf(__('Edit template %s', 'pakkasmarja_management'), Formatter::formatDocumentTemplateType($itemGroupDocumentTemplate->getType()));
          $actions["edit-template-" . $itemGroupDocumentTemplate->getId()] = sprintf('<a href="%s">%s</a>', $editUrl, $title);
        }
        
        return sprintf('%1$s%2$s', $name, $this->row_actions($actions));
      }

      /**
       * Lists item group reports
       * 
       * @param int $page page number
       * @param int $pageSize items per page
       * @return array associative array containing items and pageCount  
       */
      private function listItemGroups($page, $pageSize) {
        $firstResult = ($page - 1) * $pageSize;
        $maxResults = $pageSize;

        try {
          $result = $this->itemGroupsApi->listItemGroupsWithHttpInfo();
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