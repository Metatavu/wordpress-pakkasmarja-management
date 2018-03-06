# Metatavu\Pakkasmarja\DeliveryPlacesApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**findDeliveryPlace**](DeliveryPlacesApi.md#findDeliveryPlace) | **GET** /deliveryPlaces/{id} | Find delivery place
[**listDeliveryPlaces**](DeliveryPlacesApi.md#listDeliveryPlaces) | **GET** /deliveryPlaces | Lists delivery places


# **findDeliveryPlace**
> \Metatavu\Pakkasmarja\Api\Model\DeliveryPlace findDeliveryPlace($id)

Find delivery place

Finds delivery place by id

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\DeliveryPlacesApi(new \Http\Adapter\Guzzle6\Client());
$id = "id_example"; // string | delivery place id

try {
    $result = $api_instance->findDeliveryPlace($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryPlacesApi->findDeliveryPlace: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| delivery place id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\DeliveryPlace**](../Model/DeliveryPlace.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listDeliveryPlaces**
> \Metatavu\Pakkasmarja\Api\Model\DeliveryPlace[] listDeliveryPlaces()

Lists delivery places

Lists delivery places

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\DeliveryPlacesApi(new \Http\Adapter\Guzzle6\Client());

try {
    $result = $api_instance->listDeliveryPlaces();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryPlacesApi->listDeliveryPlaces: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\DeliveryPlace[]**](../Model/DeliveryPlace.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

