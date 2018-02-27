# Metatavu\Pakkasmarja\ItemGroupsApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**findItemGroup**](ItemGroupsApi.md#findItemGroup) | **GET** /itemGroups/{id} | Find item group
[**listItemGroups**](ItemGroupsApi.md#listItemGroups) | **GET** /itemGroups | Lists itemGroups


# **findItemGroup**
> \Metatavu\Pakkasmarja\Api\Model\ItemGroup findItemGroup($id)

Find item group

Finds item group by id

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

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

No authorization required

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listItemGroups**
> \Metatavu\Pakkasmarja\Api\Model\ItemGroup[] listItemGroups()

Lists itemGroups

Lists itemGroups

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

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

No authorization required

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

