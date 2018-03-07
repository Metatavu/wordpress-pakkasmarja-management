<?php
  namespace Metatavu\Pakkasmarja\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../vendor/autoload.php');

  if (!class_exists('\Metatavu\Pakkasmarja\Api\ContractsApiExt')) {
    
    /**
     * Class that extends ContractsApi
     */
    class ContractsApiExt extends ContractsApi {

      /**
       * Downloads contracts list as Excel file
       */
      public function listContractsXLSX() {
        $requestTemplate = $this->listContractsRequest();
        $headers = $requestTemplate->getHeaders();
        $headers['Accept'] = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
        $request = new \GuzzleHttp\Psr7\Request('GET', $requestTemplate->getUri(), $headers);
        $response = $this->client->send($request);
        return $response;
      }

    }

  }
  
?>