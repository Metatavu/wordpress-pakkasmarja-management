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
      public function listContractsXLSX($accept = null, $listAll = null, $itemGroupCategory = null, $itemGroupId = null, $year = null, $status = null, $firstResult = null, $maxResults = null) {
        $requestTemplate = $this->listContractsRequest($accept, $listAll, $itemGroupCategory, $itemGroupId, $year, $status, $firstResult, $maxResults);
        $headers = $requestTemplate->getHeaders();
        $headers['Accept'] = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
        $request = new \GuzzleHttp\Psr7\Request('GET', $requestTemplate->getUri(), $headers);
        $response = $this->client->send($request);
        return $response;
      }

    }

  }
  
?>