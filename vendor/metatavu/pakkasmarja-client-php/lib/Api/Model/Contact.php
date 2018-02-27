<?php
/**
 * Contact
 *
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
 * OpenAPI spec version: 0.0.2
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Metatavu\Pakkasmarja\Api\Model;

use \ArrayAccess;
use \Metatavu\Pakkasmarja\ObjectSerializer;

/**
 * Contact Class Doc Comment
 *
 * @category Class
 * @package  Metatavu\Pakkasmarja
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Contact implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Contact';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'firstName' => 'string',
        'lastName' => 'string',
        'companyName' => 'string',
        'phoneNumbers' => 'string[]',
        'email' => 'string',
        'addresses' => '\Metatavu\Pakkasmarja\Api\Model\Address[]',
        'bIC' => 'string',
        'iBAN' => 'string',
        'taxCode' => 'string',
        'vatLiable' => 'string',
        'audit' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => 'uuid',
        'firstName' => null,
        'lastName' => null,
        'companyName' => null,
        'phoneNumbers' => null,
        'email' => 'email',
        'addresses' => null,
        'bIC' => null,
        'iBAN' => null,
        'taxCode' => null,
        'vatLiable' => null,
        'audit' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
        'firstName' => 'firstName',
        'lastName' => 'lastName',
        'companyName' => 'companyName',
        'phoneNumbers' => 'phoneNumbers',
        'email' => 'email',
        'addresses' => 'addresses',
        'bIC' => 'BIC',
        'iBAN' => 'IBAN',
        'taxCode' => 'taxCode',
        'vatLiable' => 'vatLiable',
        'audit' => 'audit'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'firstName' => 'setFirstName',
        'lastName' => 'setLastName',
        'companyName' => 'setCompanyName',
        'phoneNumbers' => 'setPhoneNumbers',
        'email' => 'setEmail',
        'addresses' => 'setAddresses',
        'bIC' => 'setBIC',
        'iBAN' => 'setIBAN',
        'taxCode' => 'setTaxCode',
        'vatLiable' => 'setVatLiable',
        'audit' => 'setAudit'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'firstName' => 'getFirstName',
        'lastName' => 'getLastName',
        'companyName' => 'getCompanyName',
        'phoneNumbers' => 'getPhoneNumbers',
        'email' => 'getEmail',
        'addresses' => 'getAddresses',
        'bIC' => 'getBIC',
        'iBAN' => 'getIBAN',
        'taxCode' => 'getTaxCode',
        'vatLiable' => 'getVatLiable',
        'audit' => 'getAudit'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    const VAT_LIABLE_YES = 'YES';
    const VAT_LIABLE_NO = 'NO';
    const VAT_LIABLE_EU = 'EU';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getVatLiableAllowableValues()
    {
        return [
            self::VAT_LIABLE_YES,
            self::VAT_LIABLE_NO,
            self::VAT_LIABLE_EU,
        ];
    }
    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['firstName'] = isset($data['firstName']) ? $data['firstName'] : null;
        $this->container['lastName'] = isset($data['lastName']) ? $data['lastName'] : null;
        $this->container['companyName'] = isset($data['companyName']) ? $data['companyName'] : null;
        $this->container['phoneNumbers'] = isset($data['phoneNumbers']) ? $data['phoneNumbers'] : null;
        $this->container['email'] = isset($data['email']) ? $data['email'] : null;
        $this->container['addresses'] = isset($data['addresses']) ? $data['addresses'] : null;
        $this->container['bIC'] = isset($data['bIC']) ? $data['bIC'] : null;
        $this->container['iBAN'] = isset($data['iBAN']) ? $data['iBAN'] : null;
        $this->container['taxCode'] = isset($data['taxCode']) ? $data['taxCode'] : null;
        $this->container['vatLiable'] = isset($data['vatLiable']) ? $data['vatLiable'] : null;
        $this->container['audit'] = isset($data['audit']) ? $data['audit'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getVatLiableAllowableValues();
        if (!in_array($this->container['vatLiable'], $allowedValues)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'vatLiable', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        $allowedValues = $this->getVatLiableAllowableValues();
        if (!in_array($this->container['vatLiable'], $allowedValues)) {
            return false;
        }
        return true;
    }


    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->container['firstName'];
    }

    /**
     * Sets firstName
     *
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->container['firstName'] = $firstName;

        return $this;
    }

    /**
     * Gets lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->container['lastName'];
    }

    /**
     * Sets lastName
     *
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->container['lastName'] = $lastName;

        return $this;
    }

    /**
     * Gets companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->container['companyName'];
    }

    /**
     * Sets companyName
     *
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName($companyName)
    {
        $this->container['companyName'] = $companyName;

        return $this;
    }

    /**
     * Gets phoneNumbers
     *
     * @return string[]
     */
    public function getPhoneNumbers()
    {
        return $this->container['phoneNumbers'];
    }

    /**
     * Sets phoneNumbers
     *
     * @param string[] $phoneNumbers
     *
     * @return $this
     */
    public function setPhoneNumbers($phoneNumbers)
    {
        $this->container['phoneNumbers'] = $phoneNumbers;

        return $this;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->container['email'] = $email;

        return $this;
    }

    /**
     * Gets addresses
     *
     * @return \Metatavu\Pakkasmarja\Api\Model\Address[]
     */
    public function getAddresses()
    {
        return $this->container['addresses'];
    }

    /**
     * Sets addresses
     *
     * @param \Metatavu\Pakkasmarja\Api\Model\Address[] $addresses
     *
     * @return $this
     */
    public function setAddresses($addresses)
    {
        $this->container['addresses'] = $addresses;

        return $this;
    }

    /**
     * Gets bIC
     *
     * @return string
     */
    public function getBIC()
    {
        return $this->container['bIC'];
    }

    /**
     * Sets bIC
     *
     * @param string $bIC
     *
     * @return $this
     */
    public function setBIC($bIC)
    {
        $this->container['bIC'] = $bIC;

        return $this;
    }

    /**
     * Gets iBAN
     *
     * @return string
     */
    public function getIBAN()
    {
        return $this->container['iBAN'];
    }

    /**
     * Sets iBAN
     *
     * @param string $iBAN
     *
     * @return $this
     */
    public function setIBAN($iBAN)
    {
        $this->container['iBAN'] = $iBAN;

        return $this;
    }

    /**
     * Gets taxCode
     *
     * @return string
     */
    public function getTaxCode()
    {
        return $this->container['taxCode'];
    }

    /**
     * Sets taxCode
     *
     * @param string $taxCode
     *
     * @return $this
     */
    public function setTaxCode($taxCode)
    {
        $this->container['taxCode'] = $taxCode;

        return $this;
    }

    /**
     * Gets vatLiable
     *
     * @return string
     */
    public function getVatLiable()
    {
        return $this->container['vatLiable'];
    }

    /**
     * Sets vatLiable
     *
     * @param string $vatLiable
     *
     * @return $this
     */
    public function setVatLiable($vatLiable)
    {
        $allowedValues = $this->getVatLiableAllowableValues();
        if (!is_null($vatLiable) && !in_array($vatLiable, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'vatLiable', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['vatLiable'] = $vatLiable;

        return $this;
    }

    /**
     * Gets audit
     *
     * @return string
     */
    public function getAudit()
    {
        return $this->container['audit'];
    }

    /**
     * Sets audit
     *
     * @param string $audit
     *
     * @return $this
     */
    public function setAudit($audit)
    {
        $this->container['audit'] = $audit;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


