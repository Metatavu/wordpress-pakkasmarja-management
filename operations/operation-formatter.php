<?php
  
  namespace Metatavu\Pakkasmarja\Operations;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/operation-reports-table.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Operations\Formatter' ) ) {
    
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