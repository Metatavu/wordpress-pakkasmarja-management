<?php
  
  namespace Metatavu\Pakkasmarja\ItemGroups;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  use \Metatavu\Pakkasmarja\Utils\Formatter;
  
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../utils/formatter.php');
  require_once( __DIR__ . '/../utils/abstract-edit-view.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Contracts\ItemPriceTemplateEditView' ) ) {
    
    class ItemPriceTemplateEditView extends \Metatavu\Pakkasmarja\Utils\AbstractEditView {

      private $capability = 'pakkasmarja_item_group_prices_edit';
      
      /**
       * @var \Metatavu\Pakkasmarja\Api\ItemGroupsApi
       */
      private $itemGroupsApi;
      
      /**
       * Constructor
       */
      public function __construct() {
        parent::__construct();

        $this->itemGroupsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi();

        add_action( 'admin_menu', function () {
          add_submenu_page(NULL, __('Edit Item Group Price', 'pakkasmarja_management'), __('Edit Item Group Price', 'pakkasmarja_management'), $this->capability, 'pakkasmarja-item-group-price-edit-view.php', [ $this, 'renderEditView' ]);
        });
      }

      /**
       * Renders edit view
       */
      public function renderEditView() {        
        wp_register_script('jquery-datatables', 'https://cdn.metatavu.io/libs/datatables.net/1.10.16/datatables.net/js/jquery.dataTables.js');
        wp_register_style('jquery-datatables', 'https://cdn.metatavu.io/libs/datatables.net/1.10.16/datatables.net-dt/css/jquery.dataTables.css');
        
        wp_enqueue_script('item-groups-price-edit-view', plugin_dir_url(__FILE__) . 'item-groups-price-edit-view.js', ['jquery-datatables' ]);
        wp_enqueue_style('jquery-datatables');
        
        $itemGroupId = sanitize_text_field($_GET['item-group-id']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $validateMessage = $this->validatePost();
          if ($validateMessage) {
            echo '<div class="notice-error notice">' . $validateMessage . '</div>';
          } else {
            $this->save();
          }
        }

        $itemGroup = $this->findItemGroupById($itemGroupId);
        $itemGroupName = $itemGroup->getName();

        $prices = $this->itemGroupsApi->listItemGroupPrices($itemGroupId, "YEAR", "DESC");
        $backLink = sprintf('<a href="%s" class="page-title-action">%s</a>', "?page=item-group.php", __('Back', 'pakkasmarja_management'));

        echo '<div class="wrap">';
        echo sprintf('<h1 class="wp-heading-inline">%s - %s %s</h1><br/><br/>', $itemGroupName, __('Prices', 'pakkasmarja_management'), $backLink);
        echo '<hr class="wp-header-end"/>';
        $this->renderTemplateForm($itemGroupId, $prices);
        echo '</div>';
      }

      /**
       * Saves form
       */
      private function save() {
        $priceCount = $this->getPostInt('price-count');

        for ($i = 0; $i < $priceCount; $i++) {
          $prefix = "price-$i";
          
          $price = new \Metatavu\Pakkasmarja\Api\Model\Price([
            "id" => $this->getPostString("$prefix-id"),
            "group" => $this->getPostString("$prefix-group"),
            "year" => $this->getPostString("$prefix-year"),
            "price" => $this->getPostString("$prefix-price"),
            "unit" => $this->getPostString("$prefix-unit")
          ]);
          
          if ($price->getId()) {
            $this->itemGroupsApi->updateItemGroupPrice($itemGroupId, $price->getId(), $price);
          } else {
            $this->itemGroupsApi->createItemGroupPrice($itemGroupId, $price);
          }              
        }
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
       * Renders edit form
       * 
       * @param String $itemGroupId item group id
       * @param \Metatavu\Pakkasmarja\Api\Model\ItemGroupPrice[] $prices prices
       */
      private function renderTemplateForm($itemGroupId, $prices) {
        $action = sprintf('admin.php?page=pakkasmarja-item-group-price-edit-view.php&action=edit&item-group-id=%s', $itemGroupId);
        $this->renderFormStart($action);
        $this->renderFormFields($prices);
        $this->renderFormEnd();
      }

      /**
       * Renders form fields
       * 
       * @param \Metatavu\Pakkasmarja\Api\Model\ItemGroupPrice[] $itemPriceTemplate prices
       */
      private function renderFormFields($prices) {
        echo "<table class=\"prices-table\"><thead>";
        echo "<tr>";
        
        $headers = [
          __('Year', 'pakkasmarja_management'),
          __('Group', 'pakkasmarja_management'),
          __('Price', 'pakkasmarja_management'),
          __('Unit', 'pakkasmarja_management'),
          ''
        ];

        foreach ($headers as $header) {
          echo sprintf("<td>%s</td>", $header);
        }

        echo "</tr><tbody>";

        $this->renderPriceTableRow("{{INDEX}}", null); 

        foreach ($prices as $index => $price) {
          $this->renderPriceTableRow($index, $price); 
        }

        echo "</tbody></table>";
        echo sprintf("<button id=\"add-price\" class=\"button button-primary\">%s</button>", __('Add Price', 'pakkasmarja_management'));
        echo sprintf('<input name="price-count" type="hidden" value="%s"/>', count($prices));
      }

      /**
       * Renders single price table row
       * 
       * @param String $index index of row to be rendered
       * @param \Metatavu\Pakkasmarja\Api\Model\Price $price price
       */
      private function renderPriceTableRow($index, $price) {
        $prefix = "price-$index";
        
        echo "<tr>";
        echo sprintf("<td><input required=\"required\" name=\"%s-year\" type=\"number\" value=\"%s\"/></td>", $prefix, $price ? $price->getYear() : '');
        echo sprintf("<td><input required=\"required\" name=\"%s-group\" type=\"text\" value=\"%s\"/></td>", $prefix, $price ? $price->getGroup() : '');
        echo sprintf("<td><input required=\"required\" name=\"%s-price\" type=\"text\" value=\"%s\"/></td>", $prefix, $price ? $price->getPrice() : '');
        echo sprintf("<td><input required=\"required\" name=\"%s-unit\" type=\"text\" value=\"%s\"/></td>", $prefix, $price ? $price->getUnit() : '');
        echo "<td>";
        
        if (!$price) {
          echo sprintf('<a class="button button-danger remove-price">%s</a>', __('Remove', 'pakkasmarja_management'));
        }

        echo sprintf("<input name=\"%s-id\" type=\"hidden\" value=\"%s\"/>", $prefix, $price ? $price->getId() : '');

        echo "</td>";
        echo "</tr>";
      }

    }
  }
  
  add_action('init', function () {
    if (is_admin()) {
      new ItemPriceTemplateEditView();
    }
  });
    
?>