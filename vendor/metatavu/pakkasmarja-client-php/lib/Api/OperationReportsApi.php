<?php
/**
 * OperationReportsApi
 * PHP version 5
 *
 * @category Class
 * @package  Metatavu\Pakkasmarja
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Pakkasmarja REST API
 *
 * REST API for Pakkasmarja
 *
 * OpenAPI spec version: 0.0.3
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Metatavu\Pakkasmarja\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use Metatavu\Pakkasmarja\ApiException;
use Metatavu\Pakkasmarja\Configuration;
use Metatavu\Pakkasmarja\HeaderSelector;
use Metatavu\Pakkasmarja\ObjectSerializer;

/**
 * OperationReportsApi Class Doc Comment
 *
 * @category Class
 * @package  Metatavu\Pakkasmarja
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class OperationReportsApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation findOperationReport
     *
     * Find operation report
     *
     * @param  string $id operation report id (required)
     *
     * @throws \Metatavu\Pakkasmarja\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Metatavu\Pakkasmarja\Api\Model\OperationReport
     */
    public function findOperationReport($id)
    {
        list($response) = $this->findOperationReportWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation findOperationReportWithHttpInfo
     *
     * Find operation report
     *
     * @param  string $id operation report id (required)
     *
     * @throws \Metatavu\Pakkasmarja\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Metatavu\Pakkasmarja\Api\Model\OperationReport, HTTP status code, HTTP response headers (array of strings)
     */
    public function findOperationReportWithHttpInfo($id)
    {
        $returnType = '\Metatavu\Pakkasmarja\Api\Model\OperationReport';
        $request = $this->findOperationReportRequest($id);

        try {

            try {
                $response = $this->client->send($request);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\OperationReport',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\BadRequest',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\Forbidden',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\InternalServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation findOperationReportAsync
     *
     * Find operation report
     *
     * @param  string $id operation report id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function findOperationReportAsync($id)
    {
        return $this->findOperationReportAsyncWithHttpInfo($id)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation findOperationReportAsyncWithHttpInfo
     *
     * Find operation report
     *
     * @param  string $id operation report id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function findOperationReportAsyncWithHttpInfo($id)
    {
        $returnType = '\Metatavu\Pakkasmarja\Api\Model\OperationReport';
        $request = $this->findOperationReportRequest($id);

        return $this->client
            ->sendAsync($request)
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'findOperationReport'
     *
     * @param  string $id operation report id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function findOperationReportRequest($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling findOperationReport'
            );
        }

        $resourcePath = '/operationReports/{id}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers= $this->headerSelector->selectHeadersForMultipart(
                ['application/json;charset=utf-8']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json;charset=utf-8'],
                ['application/json;charset=utf-8']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present

        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation listOperationReportItems
     *
     * List operation report items
     *
     * @param  string $id operation report id (required)
     *
     * @throws \Metatavu\Pakkasmarja\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Metatavu\Pakkasmarja\Api\Model\OperationReportItem[]
     */
    public function listOperationReportItems($id)
    {
        list($response) = $this->listOperationReportItemsWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation listOperationReportItemsWithHttpInfo
     *
     * List operation report items
     *
     * @param  string $id operation report id (required)
     *
     * @throws \Metatavu\Pakkasmarja\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Metatavu\Pakkasmarja\Api\Model\OperationReportItem[], HTTP status code, HTTP response headers (array of strings)
     */
    public function listOperationReportItemsWithHttpInfo($id)
    {
        $returnType = '\Metatavu\Pakkasmarja\Api\Model\OperationReportItem[]';
        $request = $this->listOperationReportItemsRequest($id);

        try {

            try {
                $response = $this->client->send($request);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\OperationReportItem[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\BadRequest',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\Forbidden',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\InternalServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation listOperationReportItemsAsync
     *
     * List operation report items
     *
     * @param  string $id operation report id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function listOperationReportItemsAsync($id)
    {
        return $this->listOperationReportItemsAsyncWithHttpInfo($id)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation listOperationReportItemsAsyncWithHttpInfo
     *
     * List operation report items
     *
     * @param  string $id operation report id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function listOperationReportItemsAsyncWithHttpInfo($id)
    {
        $returnType = '\Metatavu\Pakkasmarja\Api\Model\OperationReportItem[]';
        $request = $this->listOperationReportItemsRequest($id);

        return $this->client
            ->sendAsync($request)
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'listOperationReportItems'
     *
     * @param  string $id operation report id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function listOperationReportItemsRequest($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling listOperationReportItems'
            );
        }

        $resourcePath = '/operationReports/{id}/items';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers= $this->headerSelector->selectHeadersForMultipart(
                ['application/json;charset=utf-8']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json;charset=utf-8'],
                ['application/json;charset=utf-8']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present

        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation listOperationReports
     *
     * List operation reports
     *
     * @param  string $type filter by type (optional)
     * @param  string $sortBy sort by (CREATED) (optional)
     * @param  string $sortDir sort direction (ASC, DESC) (optional)
     * @param  int $firstResult Offset of first result. Defaults to 0 (optional)
     * @param  int $maxResults Max results. Defaults to 20 (optional)
     *
     * @throws \Metatavu\Pakkasmarja\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Metatavu\Pakkasmarja\Api\Model\OperationReport[]
     */
    public function listOperationReports($type = null, $sortBy = null, $sortDir = null, $firstResult = null, $maxResults = null)
    {
        list($response) = $this->listOperationReportsWithHttpInfo($type, $sortBy, $sortDir, $firstResult, $maxResults);
        return $response;
    }

    /**
     * Operation listOperationReportsWithHttpInfo
     *
     * List operation reports
     *
     * @param  string $type filter by type (optional)
     * @param  string $sortBy sort by (CREATED) (optional)
     * @param  string $sortDir sort direction (ASC, DESC) (optional)
     * @param  int $firstResult Offset of first result. Defaults to 0 (optional)
     * @param  int $maxResults Max results. Defaults to 20 (optional)
     *
     * @throws \Metatavu\Pakkasmarja\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Metatavu\Pakkasmarja\Api\Model\OperationReport[], HTTP status code, HTTP response headers (array of strings)
     */
    public function listOperationReportsWithHttpInfo($type = null, $sortBy = null, $sortDir = null, $firstResult = null, $maxResults = null)
    {
        $returnType = '\Metatavu\Pakkasmarja\Api\Model\OperationReport[]';
        $request = $this->listOperationReportsRequest($type, $sortBy, $sortDir, $firstResult, $maxResults);

        try {

            try {
                $response = $this->client->send($request);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\OperationReport[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\BadRequest',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\Forbidden',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Pakkasmarja\Api\Model\InternalServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation listOperationReportsAsync
     *
     * List operation reports
     *
     * @param  string $type filter by type (optional)
     * @param  string $sortBy sort by (CREATED) (optional)
     * @param  string $sortDir sort direction (ASC, DESC) (optional)
     * @param  int $firstResult Offset of first result. Defaults to 0 (optional)
     * @param  int $maxResults Max results. Defaults to 20 (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function listOperationReportsAsync($type = null, $sortBy = null, $sortDir = null, $firstResult = null, $maxResults = null)
    {
        return $this->listOperationReportsAsyncWithHttpInfo($type, $sortBy, $sortDir, $firstResult, $maxResults)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation listOperationReportsAsyncWithHttpInfo
     *
     * List operation reports
     *
     * @param  string $type filter by type (optional)
     * @param  string $sortBy sort by (CREATED) (optional)
     * @param  string $sortDir sort direction (ASC, DESC) (optional)
     * @param  int $firstResult Offset of first result. Defaults to 0 (optional)
     * @param  int $maxResults Max results. Defaults to 20 (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function listOperationReportsAsyncWithHttpInfo($type = null, $sortBy = null, $sortDir = null, $firstResult = null, $maxResults = null)
    {
        $returnType = '\Metatavu\Pakkasmarja\Api\Model\OperationReport[]';
        $request = $this->listOperationReportsRequest($type, $sortBy, $sortDir, $firstResult, $maxResults);

        return $this->client
            ->sendAsync($request)
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'listOperationReports'
     *
     * @param  string $type filter by type (optional)
     * @param  string $sortBy sort by (CREATED) (optional)
     * @param  string $sortDir sort direction (ASC, DESC) (optional)
     * @param  int $firstResult Offset of first result. Defaults to 0 (optional)
     * @param  int $maxResults Max results. Defaults to 20 (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function listOperationReportsRequest($type = null, $sortBy = null, $sortDir = null, $firstResult = null, $maxResults = null)
    {

        $resourcePath = '/operationReports';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($type !== null) {
            $queryParams['type'] = ObjectSerializer::toQueryValue($type);
        }
        // query params
        if ($sortBy !== null) {
            $queryParams['sortBy'] = ObjectSerializer::toQueryValue($sortBy);
        }
        // query params
        if ($sortDir !== null) {
            $queryParams['sortDir'] = ObjectSerializer::toQueryValue($sortDir);
        }
        // query params
        if ($firstResult !== null) {
            $queryParams['firstResult'] = ObjectSerializer::toQueryValue($firstResult);
        }
        // query params
        if ($maxResults !== null) {
            $queryParams['maxResults'] = ObjectSerializer::toQueryValue($maxResults);
        }


        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers= $this->headerSelector->selectHeadersForMultipart(
                ['application/json;charset=utf-8']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json;charset=utf-8'],
                ['application/json;charset=utf-8']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present

        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

}
