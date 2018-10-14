<?php
  namespace Metatavu\Pakkasmarja\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../vendor/autoload.php');

  if (!class_exists('\Metatavu\Pakkasmarja\Api\ChatThreadsApiExt')) {
    
    /**
     * Class that extends ChatThreadsApi
     */
    class ChatThreadsApiExt extends ChatThreadsApi {

      /**
       * Downloads chat thread report as Excel file
       */
      public function getChatThreadReportXLSX($chatThreadId, $type) {
        $accept = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
        $requestTemplate = $this->getChatThreadReportRequest($chatThreadId, $type, $accept);
        $headers = $requestTemplate->getHeaders();
        $headers['Accept'] = $accept;
        $request = new \GuzzleHttp\Psr7\Request('GET', $requestTemplate->getUri(), $headers);
        $response = $this->client->send($request);
        return $response;
      }

    }

  }
  
?>