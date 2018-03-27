# Metatavu\Pakkasmarja\SignAuthenticationServicesApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**listSignAuthenticationServices**](SignAuthenticationServicesApi.md#listSignAuthenticationServices) | **GET** /signAuthenticationServices | List sign authentication services


# **listSignAuthenticationServices**
> \Metatavu\Pakkasmarja\Api\Model\SignAuthenticationService[] listSignAuthenticationServices()

List sign authentication services

List available sign authentication services

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\SignAuthenticationServicesApi(new \Http\Adapter\Guzzle6\Client());

try {
    $result = $api_instance->listSignAuthenticationServices();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SignAuthenticationServicesApi->listSignAuthenticationServices: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\SignAuthenticationService[]**](../Model/SignAuthenticationService.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

