# Metatavu\Pakkasmarja\ThreadsApi

All URIs are relative to *https://localhost/rest/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createThreadPredefinedText**](ThreadsApi.md#createThreadPredefinedText) | **POST** /threads/{threadId}/predefinedTexts | Creates a predefined text for a thread
[**findThreadPredefinedText**](ThreadsApi.md#findThreadPredefinedText) | **GET** /threads/{threadId}/predefinedTexts/{predefinedTextId} | Finds a thread predefined text
[**listThreadPredefinedTexts**](ThreadsApi.md#listThreadPredefinedTexts) | **GET** /threads/{threadId}/predefinedTexts | List thread&#39;s predefined texts
[**updateThreadPredefinedText**](ThreadsApi.md#updateThreadPredefinedText) | **PUT** /threads/{threadId}/predefinedTexts/{predefinedTextId} | Updates a thread&#39;s predefined text


# **createThreadPredefinedText**
> \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText createThreadPredefinedText($threadId, $predefinedTextId, $payload)

Creates a predefined text for a thread

Creates predefined text for a thrad

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ThreadsApi(new \Http\Adapter\Guzzle6\Client());
$threadId = 789; // int | thread id
$predefinedTextId = 789; // int | predefined text id
$payload = new \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText(); // \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText | predefined text

try {
    $result = $api_instance->createThreadPredefinedText($threadId, $predefinedTextId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ThreadsApi->createThreadPredefinedText: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **threadId** | **int**| thread id |
 **predefinedTextId** | **int**| predefined text id |
 **payload** | [**\Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText**](../Model/ThreadPredefinedText.md)| predefined text |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText**](../Model/ThreadPredefinedText.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findThreadPredefinedText**
> \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText findThreadPredefinedText($threadId, $predefinedTextId)

Finds a thread predefined text

Finds a thread predefined text

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ThreadsApi(new \Http\Adapter\Guzzle6\Client());
$threadId = 789; // int | thread id
$predefinedTextId = 789; // int | predefined text id

try {
    $result = $api_instance->findThreadPredefinedText($threadId, $predefinedTextId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ThreadsApi->findThreadPredefinedText: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **threadId** | **int**| thread id |
 **predefinedTextId** | **int**| predefined text id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText**](../Model/ThreadPredefinedText.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listThreadPredefinedTexts**
> \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText[] listThreadPredefinedTexts($threadId)

List thread's predefined texts

Lists thread's predefined texts

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ThreadsApi(new \Http\Adapter\Guzzle6\Client());
$threadId = 789; // int | thread id

try {
    $result = $api_instance->listThreadPredefinedTexts($threadId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ThreadsApi->listThreadPredefinedTexts: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **threadId** | **int**| thread id |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText[]**](../Model/ThreadPredefinedText.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateThreadPredefinedText**
> \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText updateThreadPredefinedText($threadId, $predefinedTextId, $payload)

Updates a thread's predefined text

Updates a thread's predefined text

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Pakkasmarja\Api\ThreadsApi(new \Http\Adapter\Guzzle6\Client());
$threadId = 789; // int | thread id
$predefinedTextId = 789; // int | predefined text id
$payload = new \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText(); // \Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText | predefined text

try {
    $result = $api_instance->updateThreadPredefinedText($threadId, $predefinedTextId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ThreadsApi->updateThreadPredefinedText: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **threadId** | **int**| thread id |
 **predefinedTextId** | **int**| predefined text id |
 **payload** | [**\Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText**](../Model/ThreadPredefinedText.md)| predefined text |

### Return type

[**\Metatavu\Pakkasmarja\Api\Model\ThreadPredefinedText**](../Model/ThreadPredefinedText.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

