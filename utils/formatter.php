<?php
  
  namespace Metatavu\Pakkasmarja\Utils;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  if (!class_exists( '\Metatavu\Pakkasmarja\Utils\Formatter' ) ) {
    
    class Formatter {

      private static $DEFAULT_TIMEZONE = 'Europe/Helsinki';
      private static $DATETIME_FORMAT = 'Y-m-d H:i:s';

      /**
       * Formats operation type
       * 
       * @param string $type type
       * @return string formatted type
       */
      public static function formatOperationType($type) {
        switch ($type) {
          case "SAP_CONTACT_SYNC":
            return __('SAP Contacts synchronization', 'pakkasmarja_management');
          case "SAP_DELIVERY_PLACE_SYNC":
            return __('SAP Delivery Places synchronization', 'pakkasmarja_management');
          case "SAP_ITEM_GROUP_SYNC":
            return __('SAP Item Groups synchronization', 'pakkasmarja_management');
          case "SAP_CONTRACT_SYNC":
            return __('SAP Contracts synchronization', 'pakkasmarja_management');
          case "ITEM_GROUP_DEFAULT_DOCUMENT_TEMPLATES":
            return __('Item Group default document templates', 'pakkasmarja_management');
        }
      }

      /**
       * Formats operation item status
       * 
       * @param string $status item status
       * @return string formatted item status
       */
      public static function formatOperationItemStatus($status) {
        switch ($status) {
          case "PENDING":
            return __('Pending', 'pakkasmarja_management');
          case "FAILURE":
            return __('Failure', 'pakkasmarja_management');
          case "SUCCESS":
            return __('Success', 'pakkasmarja_management');
        }
      }

      /**
       * Formats contract status
       * 
       * @param string $status contract status
       * @return string formatted contract status
       */
      public static function formatContractStatus($status) {
        switch ($status) {
          case "APPROVED":
            return __('Approved', 'pakkasmarja_management');
          case "ON_HOLD":
            return __('On Hold', 'pakkasmarja_management');
          case "DRAFT":
            return __('Draft', 'pakkasmarja_management');
          case "TERMINATED":
            return __('Terminated', 'pakkasmarja_management');
        }
      }

      /**
       * Formats document template type
       * 
       * @param string $type contract template type
       * @return string formatted contract template type
       */
      public static function formatDocumentTemplateType($type) {
        switch ($type) {
          case "master":
            return __('Master', 'pakkasmarja_management');
          case "group":
            return __('Group', 'pakkasmarja_management');
        }

        return $type;
      }

      /**
       * Returns date time as string
       * 
       * @param \DateTime $dateTime date time
       * @return string formatted date time
       */
      public static function formatDateTime($dateTime) {
        if ($dateTime) {
          $clone = clone $dateTime;
          $clone->setTimezone(self::getTimezone());
          return $clone->format(self::$DATETIME_FORMAT);
        }
        
        return null;
      }

      /**
       * Resolves company name by contact id
       * 
       * @param string $contactId contactId
       * @return string contact's company name
       */
      public static function getCompanyName($contactId) {
        $contact = self::findContactById($contactId);
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
      public static function getItemGroupName($itemGroupId) {
        $itemGroup = self::findItemGroupById($itemGroupId);
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
      public static function getDeliveryPlaceName($deliveryPlaceId) {
        $deliveryPlace = self::findDeliveryPlaceById($deliveryPlaceId);
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
      private static function findItemGroupById($itemGroupId) {
        try {
          return \Metatavu\Pakkasmarja\Api\ApiClient::getItemGroupsApi()->findItemGroup($itemGroupId);
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
      private static function findContactById($contactId) {
        try {
          return \Metatavu\Pakkasmarja\Api\ApiClient::getContactsApi()->findContact($contactId);
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
      private static function findDeliveryPlaceById($deliveryPlaceId) {
        try {
          return \Metatavu\Pakkasmarja\Api\ApiClient::getDeliveryPlacesApi()->findDeliveryPlace($deliveryPlaceId);
        } catch (\Metatavu\Pakkasmarja\ApiException | \InvalidArgumentException $e) {
          $message = $e->getMessage();
          error_log("Failed to find delivery place #$deliveryPlaceId: $message");
          return null;
        }
      }
      
      /**
       * Returns time zone
       * 
       * @return \DateTimeZone time zone
       */
      private static function getTimezone() {
        return new \DateTimeZone($result ? $result : self::$DEFAULT_TIMEZONE);
      }

    }

  }

?>