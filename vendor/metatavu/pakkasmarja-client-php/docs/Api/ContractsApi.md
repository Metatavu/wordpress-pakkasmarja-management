# Metatavu\Pakkasmarja\ContractsApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createContract**](ContractsApi.md#createContract) | **POST** /contracts | Create contract
[**createContractDocumentSignRequest**](ContractsApi.md#createContractDocumentSignRequest) | **POST** /contracts/{id}/documents/{type}/signRequests | Requests contract document electronic signing
[**createContractDocumentTemplate**](ContractsApi.md#createContractDocumentTemplate) | **POST** /contracts/{contractId}/documentTemplates | Create contract document template
[**findContract**](ContractsApi.md#findContract) | **GET** /contracts/{id} | Find contract
[**findContractDocumentTemplate**](ContractsApi.md#findContractDocumentTemplate) | **GET** /contracts/{contractId}/documentTemplates/{contractDocumentTemplateId} | Find contract document template
[**getContractDocument**](ContractsApi.md#getContractDocument) | **GET** /contracts/{id}/documents/{type} | Returns contract document
[**listContractDocumentTemplates**](ContractsApi.md#listContractDocumentTemplates) | **GET** /contracts/{contractId}/documentTemplates | List contract document templates
[**listContractPrices**](ContractsApi.md#listContractPrices) | **GET** /contracts/{contractId}/prices | List contract prices
[**listContracts**](ContractsApi.md#listContracts) | **GET** /contracts | Lists contracts
[**updateContract**](ContractsApi.md#updateContract) | **PUT** /contracts/{id} | Update contract
[**updateContractDocumentTemplate**](ContractsApi.md#updateContractDocumentTemplate) | **PUT** /contracts/{contractId}/documentTemplates/{contractDocumentTemplateId} | Updates contract document template


# **createContract**
> \Metatavu\Pakkasmarja\Api\Model\Contract createContract($body)

Create contract

Create new contract

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$body = new \Metatavu\Pakkasmarja\Api\Model\Contract(); // \Metatavu\Pakkasmarja\Api\Model\Contract | Payload

try {
    $result = $api_instance->createContract($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->createContract: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\Contract**](../Model/Contract.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\Contract**](../Model/Contract.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **createContractDocumentSignRequest**
> \Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest createContractDocumentSignRequest($id, $type, $ssn, $authService, $body)

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
$ssn = "ssn_example"; // string | Social security number
$authService = "authService_example"; // string | Used auth service name
$body = new \Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest(); // \Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest | Payload

try {
    $result = $api_instance->createContractDocumentSignRequest($id, $type, $ssn, $authService, $body);
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
 **ssn** | **string**| Social security number |
 **authService** | **string**| Used auth service name |
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest**](../Model/ContractDocumentSignRequest.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentSignRequest**](../Model/ContractDocumentSignRequest.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **createContractDocumentTemplate**
> \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate createContractDocumentTemplate($contractId, $body)

Create contract document template

Create new contract document template

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$contractId = "contractId_example"; // string | contract id
$body = new \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate(); // \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate | Payload

try {
    $result = $api_instance->createContractDocumentTemplate($contractId, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->createContractDocumentTemplate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contractId** | **string**| contract id |
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate**](../Model/ContractDocumentTemplate.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate**](../Model/ContractDocumentTemplate.md)

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

# **findContractDocumentTemplate**
> \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate findContractDocumentTemplate($contractId, $contractDocumentTemplateId)

Find contract document template

Finds a contract templates

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$contractId = "contractId_example"; // string | contract id
$contractDocumentTemplateId = "contractDocumentTemplateId_example"; // string | contract id

try {
    $result = $api_instance->findContractDocumentTemplate($contractId, $contractDocumentTemplateId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->findContractDocumentTemplate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contractId** | **string**| contract id |
 **contractDocumentTemplateId** | **string**| contract id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate**](../Model/ContractDocumentTemplate.md)

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

# **listContractDocumentTemplates**
> \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate[] listContractDocumentTemplates($contractId, $type)

List contract document templates

Lists contract templates

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$contractId = "contractId_example"; // string | contract id
$type = "type_example"; // string | Filter results by document template type

try {
    $result = $api_instance->listContractDocumentTemplates($contractId, $type);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->listContractDocumentTemplates: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contractId** | **string**| contract id |
 **type** | **string**| Filter results by document template type | [optional]

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate[]**](../Model/ContractDocumentTemplate.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listContractPrices**
> \Metatavu\Pakkasmarja\Api\Model\Price[] listContractPrices($contractId, $sortBy, $sortDir, $firstResult, $maxResults)

List contract prices

Lists contract prices

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$contractId = "contractId_example"; // string | contract id
$sortBy = "sortBy_example"; // string | sort by (YEAR)
$sortDir = "sortDir_example"; // string | sort direction (ASC, DESC)
$firstResult = 789; // int | Offset of first result. Defaults to 0
$maxResults = 789; // int | Max results. Defaults to 5

try {
    $result = $api_instance->listContractPrices($contractId, $sortBy, $sortDir, $firstResult, $maxResults);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->listContractPrices: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contractId** | **string**| contract id |
 **sortBy** | **string**| sort by (YEAR) | [optional]
 **sortDir** | **string**| sort direction (ASC, DESC) | [optional]
 **firstResult** | **int**| Offset of first result. Defaults to 0 | [optional]
 **maxResults** | **int**| Max results. Defaults to 5 | [optional]

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\Price[]**](../Model/Price.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listContracts**
> \Metatavu\Pakkasmarja\Api\Model\Contract[] listContracts($accept, $listAll, $itemGroupCategory, $itemGroupId, $year, $status, $firstResult, $maxResults)

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
$listAll = true; // bool | Returns all contracts instead of just user's own contracts. User must have permission to do this.
$itemGroupCategory = "itemGroupCategory_example"; // string | Filters results by item group category.
$itemGroupId = "itemGroupId_example"; // string | Filters results by item group id.
$year = 56; // int | Filters results by year.
$status = "status_example"; // string | Filters results by status
$firstResult = 789; // int | Offset of first result. Defaults to 0
$maxResults = 789; // int | Max results. Defaults to 5

try {
    $result = $api_instance->listContracts($accept, $listAll, $itemGroupCategory, $itemGroupId, $year, $status, $firstResult, $maxResults);
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
 **listAll** | **bool**| Returns all contracts instead of just user&#39;s own contracts. User must have permission to do this. | [optional]
 **itemGroupCategory** | **string**| Filters results by item group category. | [optional]
 **itemGroupId** | **string**| Filters results by item group id. | [optional]
 **year** | **int**| Filters results by year. | [optional]
 **status** | **string**| Filters results by status | [optional]
 **firstResult** | **int**| Offset of first result. Defaults to 0 | [optional]
 **maxResults** | **int**| Max results. Defaults to 5 | [optional]

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

# **updateContractDocumentTemplate**
> \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate updateContractDocumentTemplate($contractId, $contractDocumentTemplateId, $body)

Updates contract document template

Updates a contract templates

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ContractsApi(new \Http\Adapter\Guzzle6\Client());
$contractId = "contractId_example"; // string | contract id
$contractDocumentTemplateId = "contractDocumentTemplateId_example"; // string | contract id
$body = new \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate(); // \Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate | Payload

try {
    $result = $api_instance->updateContractDocumentTemplate($contractId, $contractDocumentTemplateId, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContractsApi->updateContractDocumentTemplate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contractId** | **string**| contract id |
 **contractDocumentTemplateId** | **string**| contract id |
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate**](../Model/ContractDocumentTemplate.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ContractDocumentTemplate**](../Model/ContractDocumentTemplate.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

