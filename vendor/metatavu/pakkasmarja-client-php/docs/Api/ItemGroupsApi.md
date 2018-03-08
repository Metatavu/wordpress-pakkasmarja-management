# Metatavu\Pakkasmarja\ItemGroupsApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**findItemGroup**](ItemGroupsApi.md#findItemGroup) | **GET** /itemGroups/{id} | Find item group
[**findItemGroupDocumentTemplate**](ItemGroupsApi.md#findItemGroupDocumentTemplate) | **GET** /itemGroups/{itemGroupId}/documentTemplates/{id} | Find item group document template
[**listItemGroupDocumentTemplates**](ItemGroupsApi.md#listItemGroupDocumentTemplates) | **GET** /itemGroups/{itemGroupId}/documentTemplates | List item group document templates
[**listItemGroups**](ItemGroupsApi.md#listItemGroups) | **GET** /itemGroups | Lists item groups
[**updateItemGroupDocumentTemplate**](ItemGroupsApi.md#updateItemGroupDocumentTemplate) | **PUT** /itemGroups/{itemGroupId}/documentTemplates/{id} | Updates item group document template


# **findItemGroup**
> \Metatavu\Pakkasmarja\Api\Model\ItemGroup findItemGroup($id)

Find item group

Finds item group by id

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ItemGroupsApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | item group id

try {
    $result = $api_instance->findItemGroup($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ItemGroupsApi->findItemGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| item group id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ItemGroup**](../Model/ItemGroup.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findItemGroupDocumentTemplate**
> \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate findItemGroupDocumentTemplate($itemGroupId, $id)

Find item group document template

Finds item group template

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ItemGroupsApi(new \Http\Adapter\Guzzle6\Client());
$itemGroupId = "itemGroupId_example"; // string | item group id
$id = "id_example"; // string | template id

try {
    $result = $api_instance->findItemGroupDocumentTemplate($itemGroupId, $id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ItemGroupsApi->findItemGroupDocumentTemplate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **itemGroupId** | **string**| item group id |
 **id** | **string**| template id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate**](../Model/ItemGroupDocumentTemplate.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listItemGroupDocumentTemplates**
> \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate[] listItemGroupDocumentTemplates($itemGroupId)

List item group document templates

Lists item group templates

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ItemGroupsApi(new \Http\Adapter\Guzzle6\Client());
$itemGroupId = "itemGroupId_example"; // string | item group id

try {
    $result = $api_instance->listItemGroupDocumentTemplates($itemGroupId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ItemGroupsApi->listItemGroupDocumentTemplates: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **itemGroupId** | **string**| item group id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate[]**](../Model/ItemGroupDocumentTemplate.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listItemGroups**
> \Metatavu\Pakkasmarja\Api\Model\ItemGroup[] listItemGroups()

Lists item groups

Lists item groups

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ItemGroupsApi(new \Http\Adapter\Guzzle6\Client());

try {
    $result = $api_instance->listItemGroups();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ItemGroupsApi->listItemGroups: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ItemGroup[]**](../Model/ItemGroup.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateItemGroupDocumentTemplate**
> \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate updateItemGroupDocumentTemplate($itemGroupId, $id, $body)

Updates item group document template

Updated item group document template

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ItemGroupsApi(new \Http\Adapter\Guzzle6\Client());
$itemGroupId = "itemGroupId_example"; // string | item group id
$id = "id_example"; // string | template id
$body = new \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate(); // \Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate | Payload

try {
    $result = $api_instance->updateItemGroupDocumentTemplate($itemGroupId, $id, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ItemGroupsApi->updateItemGroupDocumentTemplate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **itemGroupId** | **string**| item group id |
 **id** | **string**| template id |
 **body** | [**\Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate**](../Model/ItemGroupDocumentTemplate.md)| Payload |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ItemGroupDocumentTemplate**](../Model/ItemGroupDocumentTemplate.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

