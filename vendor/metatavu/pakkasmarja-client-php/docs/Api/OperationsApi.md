# Metatavu\Pakkasmarja\OperationsApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createOperation**](OperationsApi.md#createOperation) | **POST** /operations | Creates new operation


# **createOperation**
> \Metatavu\Pakkasmarja\Api\Model\Operation createOperation($body)

Creates new operation

Creates new operation

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\OperationsApi(new \Http\Adapter\Guzzle6\Client());
$body = new \Metatavu\Pakkasmarja\Api\Model\Operation(); // \Metatavu\Pakkasmarja\Api\Model\Operation | Payload

try {
    $result = $api_instance->createOperation($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OperationsApi->createOperation: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\Operation**](../Model/Operation.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\Operation**](../Model/Operation.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

