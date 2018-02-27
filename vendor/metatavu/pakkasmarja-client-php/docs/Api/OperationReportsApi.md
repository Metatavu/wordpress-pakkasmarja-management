# Metatavu\Pakkasmarja\OperationReportsApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**findOperationReport**](OperationReportsApi.md#findOperationReport) | **GET** /operationReports/{id} | Find operation report
[**listOperationReportItems**](OperationReportsApi.md#listOperationReportItems) | **GET** /operationReports/{id}/items | List operation report items
[**listOperationReports**](OperationReportsApi.md#listOperationReports) | **GET** /operationReports | List operation reports


# **findOperationReport**
> \Metatavu\Pakkasmarja\Api\Model\OperationReport findOperationReport($id)

Find operation report

Find operation report by id

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\OperationReportsApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | operation report id

try {
    $result = $api_instance->findOperationReport($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OperationReportsApi->findOperationReport: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| operation report id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\OperationReport**](../Model/OperationReport.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listOperationReportItems**
> \Metatavu\Pakkasmarja\Api\Model\OperationReportItem listOperationReportItems($id)

List operation report items

Lists operation report items

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\OperationReportsApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | operation report id

try {
    $result = $api_instance->listOperationReportItems($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OperationReportsApi->listOperationReportItems: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| operation report id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\OperationReportItem**](../Model/OperationReportItem.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listOperationReports**
> \Metatavu\Pakkasmarja\Api\Model\OperationReport[] listOperationReports($type, $sortBy, $sortDir, $firstResult, $maxResults)

List operation reports

Lists operation reports

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\OperationReportsApi(new \Http\Adapter\Guzzle6\Client());
$type = "type_example"; // string | filter by type
$sortBy = "sortBy_example"; // string | sort by (CREATED)
$sortDir = "sortDir_example"; // string | sort direction (ASC, DESC)
$firstResult = 789; // int | Offset of first result. Defaults to 0
$maxResults = 789; // int | Max results. Defaults to 20

try {
    $result = $api_instance->listOperationReports($type, $sortBy, $sortDir, $firstResult, $maxResults);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OperationReportsApi->listOperationReports: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **type** | **string**| filter by type | [optional]
 **sortBy** | **string**| sort by (CREATED) | [optional]
 **sortDir** | **string**| sort direction (ASC, DESC) | [optional]
 **firstResult** | **int**| Offset of first result. Defaults to 0 | [optional]
 **maxResults** | **int**| Max results. Defaults to 20 | [optional]

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\OperationReport[]**](../Model/OperationReport.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

