<?php
  
  namespace Metatavu\Pakkasmarja\Utils;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  if (!class_exists( '\Metatavu\Pakkasmarja\Utils\Consts' ) ) {
    
    class Consts {

      const CONTRACT_STATUSES = ["APPROVED", "ON_HOLD", "DRAFT", "TERMINATED", "REJECTED"];

    }

  }

?>