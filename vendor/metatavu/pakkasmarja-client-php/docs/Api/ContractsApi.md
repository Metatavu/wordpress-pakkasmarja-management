# Metatavu\Pakkasmarja\ContractsApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createContractDocumentSignRequest**](ContractsApi.md#createContractDocumentSignRequest) | **POST** /contracts/{id}/documents/{type}/signRequests | Requests contract document electronic signing
[**findContract**](ContractsApi.md#findContract) | **GET** /contracts/{id} | Find contract
[**getContractDocument**](ContractsApi.md#getContractDocument) | **GET** /contracts/{id}/documents/{type} | Returns contract document
[**listContracts**](ContractsApi.md#listContracts) | **GET** /contracts | Lists contracts
[**updateContract**](ContractsApi.md#updateContract) | **PUT** /contracts/{id} | Update contract


# **createContractDocumentSignRequest**
> \Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest createContractDocumentSignRequest($id, $type, $body)

Requests contract document electronic signing

Requests contract document electronic signing

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | contract id
$type = "type_example"; // string | document type
$body = new \Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest(); // \Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest | Payload

try {
    $result = $api_instance->createContractDocumentSignRequest($id, $type, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->createContractDocumentSignRequest: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| contract id |
 **type** | **string**| document type |
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest**](../Model/ContractDocumentSignRequest.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest**](../Model/ContractDocumentSignRequest.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findContract**
> \Metatavu\Pakkasmarja\Api\Model\Contract findContract($id, $accept)

Find contract

Finds contract by id

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | contract id
$accept = "accept_example"; // string | Expected response format. Accepted values application/json for JSON reponse (default) and application/vnd.openxmlformats-officedocument.spreadsheetml.sheet for Excel response

try {
    $result = $api_instance->findContract($id, $accept);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->findContract: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| contract id |
 **accept** | **string**| Expected response format. Accepted values application/json for JSON reponse (default) and application/vnd.openxmlformats-officedocument.spreadsheetml.sheet for Excel response | [optional]

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\Contract**](../Model/Contract.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getContractDocument**
> string getContractDocument($id, $type, $format)

Returns contract document

Returns contract document by type

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | contract id
$type = "type_example"; // string | document type
$format = "format_example"; // string | document format (HTML or PDF)

try {
    $result = $api_instance->getContractDocument($id, $type, $format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->getContractDocument: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| contract id |
 **type** | **string**| document type |
 **format** | **string**| document format (HTML or PDF) |

### Return type

**string**

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listContracts**
> \Metatavu\Pakkasmarja\Api\Model\Contract[] listContracts($accept)

Lists contracts

Lists contracts

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$accept = "accept_example"; // string | Expected response format. Accepted values application/json for JSON reponse (default) and application/vnd.openxmlformats-officedocument.spreadsheetml.sheet for Excel response

try {
    $result = $api_instance->listContracts($accept);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->listContracts: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **accept** | **string**| Expected response format. Accepted values application/json for JSON reponse (default) and application/vnd.openxmlformats-officedocument.spreadsheetml.sheet for Excel response | [optional]

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\Contract[]**](../Model/Contract.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateContract**
> \Metatavu\Pakkasmarja\Api\Model\Contract updateContract($id, $body)

Update contract

Updates single contract

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | contract id
$body = new \Metatavu\Pakkasmarja\Api\Model\Contract(); // \Metatavu\Pakkasmarja\Api\Model\Contract | Payload

try {
    $result = $api_instance->updateContract($id, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->updateContract: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| contract id |
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\Contract**](../Model/Contract.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\Contract**](../Model/Contract.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

