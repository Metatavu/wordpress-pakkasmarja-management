<?php
/**
 * Contract
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
 * OpenAPI spec version: 0.0.3
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
 * Contract Class Doc Comment
 *
 * @category Class
 * @package  Metatavu\Pakkasmarja
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Contract implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Contract';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'sapId' => 'string',
        'contactId' => 'string',
        'deliveryPlaceId' => 'string',
        'proposedDeliveryPlaceId' => 'string',
        'deliveryPlaceComment' => 'string',
        'itemGroupId' => 'string',
        'year' => 'int',
        'contractQuantity' => 'double',
        'deliveredQuantity' => 'double',
        'proposedQuantity' => 'double',
        'quantityComment' => 'string',
        'startDate' => '\DateTime',
        'endDate' => '\DateTime',
        'signDate' => '\DateTime',
        'termDate' => '\DateTime',
        'rejectComment' => 'string',
        'areaDetails' => '\Metatavu\Pakkasmarja\Api\Model\AreaDetail[]',
        'deliverAll' => 'bool',
        'status' => 'string',
        'remarks' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => 'uuid',
        'sapId' => null,
        'contactId' => 'uuid',
        'deliveryPlaceId' => 'uuid',
        'proposedDeliveryPlaceId' => 'uuid',
        'deliveryPlaceComment' => null,
        'itemGroupId' => 'uuid',
        'year' => 'int32',
        'contractQuantity' => 'double',
        'deliveredQuantity' => 'double',
        'proposedQuantity' => 'double',
        'quantityComment' => null,
        'startDate' => 'date',
        'endDate' => 'date',
        'signDate' => 'date',
        'termDate' => 'date',
        'rejectComment' => null,
        'areaDetails' => null,
        'deliverAll' => null,
        'status' => null,
        'remarks' => null
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
        'sapId' => 'sapId',
        'contactId' => 'contactId',
        'deliveryPlaceId' => 'deliveryPlaceId',
        'proposedDeliveryPlaceId' => 'proposedDeliveryPlaceId',
        'deliveryPlaceComment' => 'deliveryPlaceComment',
        'itemGroupId' => 'itemGroupId',
        'year' => 'year',
        'contractQuantity' => 'contractQuantity',
        'deliveredQuantity' => 'deliveredQuantity',
        'proposedQuantity' => 'proposedQuantity',
        'quantityComment' => 'quantityComment',
        'startDate' => 'startDate',
        'endDate' => 'endDate',
        'signDate' => 'signDate',
        'termDate' => 'termDate',
        'rejectComment' => 'rejectComment',
        'areaDetails' => 'areaDetails',
        'deliverAll' => 'deliverAll',
        'status' => 'status',
        'remarks' => 'remarks'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'sapId' => 'setSapId',
        'contactId' => 'setContactId',
        'deliveryPlaceId' => 'setDeliveryPlaceId',
        'proposedDeliveryPlaceId' => 'setProposedDeliveryPlaceId',
        'deliveryPlaceComment' => 'setDeliveryPlaceComment',
        'itemGroupId' => 'setItemGroupId',
        'year' => 'setYear',
        'contractQuantity' => 'setContractQuantity',
        'deliveredQuantity' => 'setDeliveredQuantity',
        'proposedQuantity' => 'setProposedQuantity',
        'quantityComment' => 'setQuantityComment',
        'startDate' => 'setStartDate',
        'endDate' => 'setEndDate',
        'signDate' => 'setSignDate',
        'termDate' => 'setTermDate',
        'rejectComment' => 'setRejectComment',
        'areaDetails' => 'setAreaDetails',
        'deliverAll' => 'setDeliverAll',
        'status' => 'setStatus',
        'remarks' => 'setRemarks'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'sapId' => 'getSapId',
        'contactId' => 'getContactId',
        'deliveryPlaceId' => 'getDeliveryPlaceId',
        'proposedDeliveryPlaceId' => 'getProposedDeliveryPlaceId',
        'deliveryPlaceComment' => 'getDeliveryPlaceComment',
        'itemGroupId' => 'getItemGroupId',
        'year' => 'getYear',
        'contractQuantity' => 'getContractQuantity',
        'deliveredQuantity' => 'getDeliveredQuantity',
        'proposedQuantity' => 'getProposedQuantity',
        'quantityComment' => 'getQuantityComment',
        'startDate' => 'getStartDate',
        'endDate' => 'getEndDate',
        'signDate' => 'getSignDate',
        'termDate' => 'getTermDate',
        'rejectComment' => 'getRejectComment',
        'areaDetails' => 'getAreaDetails',
        'deliverAll' => 'getDeliverAll',
        'status' => 'getStatus',
        'remarks' => 'getRemarks'
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

    const STATUS_APPROVED = 'APPROVED';
    const STATUS_ON_HOLD = 'ON_HOLD';
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_TERMINATED = 'TERMINATED';
    const STATUS_REJECTED = 'REJECTED';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getStatusAllowableValues()
    {
        return [
            self::STATUS_APPROVED,
            self::STATUS_ON_HOLD,
            self::STATUS_DRAFT,
            self::STATUS_TERMINATED,
            self::STATUS_REJECTED,
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
        $this->container['sapId'] = isset($data['sapId']) ? $data['sapId'] : null;
        $this->container['contactId'] = isset($data['contactId']) ? $data['contactId'] : null;
        $this->container['deliveryPlaceId'] = isset($data['deliveryPlaceId']) ? $data['deliveryPlaceId'] : null;
        $this->container['proposedDeliveryPlaceId'] = isset($data['proposedDeliveryPlaceId']) ? $data['proposedDeliveryPlaceId'] : null;
        $this->container['deliveryPlaceComment'] = isset($data['deliveryPlaceComment']) ? $data['deliveryPlaceComment'] : null;
        $this->container['itemGroupId'] = isset($data['itemGroupId']) ? $data['itemGroupId'] : null;
        $this->container['year'] = isset($data['year']) ? $data['year'] : null;
        $this->container['contractQuantity'] = isset($data['contractQuantity']) ? $data['contractQuantity'] : null;
        $this->container['deliveredQuantity'] = isset($data['deliveredQuantity']) ? $data['deliveredQuantity'] : null;
        $this->container['proposedQuantity'] = isset($data['proposedQuantity']) ? $data['proposedQuantity'] : null;
        $this->container['quantityComment'] = isset($data['quantityComment']) ? $data['quantityComment'] : null;
        $this->container['startDate'] = isset($data['startDate']) ? $data['startDate'] : null;
        $this->container['endDate'] = isset($data['endDate']) ? $data['endDate'] : null;
        $this->container['signDate'] = isset($data['signDate']) ? $data['signDate'] : null;
        $this->container['termDate'] = isset($data['termDate']) ? $data['termDate'] : null;
        $this->container['rejectComment'] = isset($data['rejectComment']) ? $data['rejectComment'] : null;
        $this->container['areaDetails'] = isset($data['areaDetails']) ? $data['areaDetails'] : null;
        $this->container['deliverAll'] = isset($data['deliverAll']) ? $data['deliverAll'] : null;
        $this->container['status'] = isset($data['status']) ? $data['status'] : null;
        $this->container['remarks'] = isset($data['remarks']) ? $data['remarks'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getStatusAllowableValues();
        if (!in_array($this->container['status'], $allowedValues)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'status', must be one of '%s'",
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

        $allowedValues = $this->getStatusAllowableValues();
        if (!in_array($this->container['status'], $allowedValues)) {
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
     * Gets sapId
     *
     * @return string
     */
    public function getSapId()
    {
        return $this->container['sapId'];
    }

    /**
     * Sets sapId
     *
     * @param string $sapId
     *
     * @return $this
     */
    public function setSapId($sapId)
    {
        $this->container['sapId'] = $sapId;

        return $this;
    }

    /**
     * Gets contactId
     *
     * @return string
     */
    public function getContactId()
    {
        return $this->container['contactId'];
    }

    /**
     * Sets contactId
     *
     * @param string $contactId
     *
     * @return $this
     */
    public function setContactId($contactId)
    {
        $this->container['contactId'] = $contactId;

        return $this;
    }

    /**
     * Gets deliveryPlaceId
     *
     * @return string
     */
    public function getDeliveryPlaceId()
    {
        return $this->container['deliveryPlaceId'];
    }

    /**
     * Sets deliveryPlaceId
     *
     * @param string $deliveryPlaceId
     *
     * @return $this
     */
    public function setDeliveryPlaceId($deliveryPlaceId)
    {
        $this->container['deliveryPlaceId'] = $deliveryPlaceId;

        return $this;
    }

    /**
     * Gets proposedDeliveryPlaceId
     *
     * @return string
     */
    public function getProposedDeliveryPlaceId()
    {
        return $this->container['proposedDeliveryPlaceId'];
    }

    /**
     * Sets proposedDeliveryPlaceId
     *
     * @param string $proposedDeliveryPlaceId
     *
     * @return $this
     */
    public function setProposedDeliveryPlaceId($proposedDeliveryPlaceId)
    {
        $this->container['proposedDeliveryPlaceId'] = $proposedDeliveryPlaceId;

        return $this;
    }

    /**
     * Gets deliveryPlaceComment
     *
     * @return string
     */
    public function getDeliveryPlaceComment()
    {
        return $this->container['deliveryPlaceComment'];
    }

    /**
     * Sets deliveryPlaceComment
     *
     * @param string $deliveryPlaceComment
     *
     * @return $this
     */
    public function setDeliveryPlaceComment($deliveryPlaceComment)
    {
        $this->container['deliveryPlaceComment'] = $deliveryPlaceComment;

        return $this;
    }

    /**
     * Gets itemGroupId
     *
     * @return string
     */
    public function getItemGroupId()
    {
        return $this->container['itemGroupId'];
    }

    /**
     * Sets itemGroupId
     *
     * @param string $itemGroupId
     *
     * @return $this
     */
    public function setItemGroupId($itemGroupId)
    {
        $this->container['itemGroupId'] = $itemGroupId;

        return $this;
    }

    /**
     * Gets year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->container['year'];
    }

    /**
     * Sets year
     *
     * @param int $year
     *
     * @return $this
     */
    public function setYear($year)
    {
        $this->container['year'] = $year;

        return $this;
    }

    /**
     * Gets contractQuantity
     *
     * @return double
     */
    public function getContractQuantity()
    {
        return $this->container['contractQuantity'];
    }

    /**
     * Sets contractQuantity
     *
     * @param double $contractQuantity
     *
     * @return $this
     */
    public function setContractQuantity($contractQuantity)
    {
        $this->container['contractQuantity'] = $contractQuantity;

        return $this;
    }

    /**
     * Gets deliveredQuantity
     *
     * @return double
     */
    public function getDeliveredQuantity()
    {
        return $this->container['deliveredQuantity'];
    }

    /**
     * Sets deliveredQuantity
     *
     * @param double $deliveredQuantity
     *
     * @return $this
     */
    public function setDeliveredQuantity($deliveredQuantity)
    {
        $this->container['deliveredQuantity'] = $deliveredQuantity;

        return $this;
    }

    /**
     * Gets proposedQuantity
     *
     * @return double
     */
    public function getProposedQuantity()
    {
        return $this->container['proposedQuantity'];
    }

    /**
     * Sets proposedQuantity
     *
     * @param double $proposedQuantity
     *
     * @return $this
     */
    public function setProposedQuantity($proposedQuantity)
    {
        $this->container['proposedQuantity'] = $proposedQuantity;

        return $this;
    }

    /**
     * Gets quantityComment
     *
     * @return string
     */
    public function getQuantityComment()
    {
        return $this->container['quantityComment'];
    }

    /**
     * Sets quantityComment
     *
     * @param string $quantityComment
     *
     * @return $this
     */
    public function setQuantityComment($quantityComment)
    {
        $this->container['quantityComment'] = $quantityComment;

        return $this;
    }

    /**
     * Gets startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->container['startDate'];
    }

    /**
     * Sets startDate
     *
     * @param \DateTime $startDate
     *
     * @return $this
     */
    public function setStartDate($startDate)
    {
        $this->container['startDate'] = $startDate;

        return $this;
    }

    /**
     * Gets endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->container['endDate'];
    }

    /**
     * Sets endDate
     *
     * @param \DateTime $endDate
     *
     * @return $this
     */
    public function setEndDate($endDate)
    {
        $this->container['endDate'] = $endDate;

        return $this;
    }

    /**
     * Gets signDate
     *
     * @return \DateTime
     */
    public function getSignDate()
    {
        return $this->container['signDate'];
    }

    /**
     * Sets signDate
     *
     * @param \DateTime $signDate
     *
     * @return $this
     */
    public function setSignDate($signDate)
    {
        $this->container['signDate'] = $signDate;

        return $this;
    }

    /**
     * Gets termDate
     *
     * @return \DateTime
     */
    public function getTermDate()
    {
        return $this->container['termDate'];
    }

    /**
     * Sets termDate
     *
     * @param \DateTime $termDate
     *
     * @return $this
     */
    public function setTermDate($termDate)
    {
        $this->container['termDate'] = $termDate;

        return $this;
    }

    /**
     * Gets rejectComment
     *
     * @return string
     */
    public function getRejectComment()
    {
        return $this->container['rejectComment'];
    }

    /**
     * Sets rejectComment
     *
     * @param string $rejectComment
     *
     * @return $this
     */
    public function setRejectComment($rejectComment)
    {
        $this->container['rejectComment'] = $rejectComment;

        return $this;
    }

    /**
     * Gets areaDetails
     *
     * @return \Metatavu\Pakkasmarja\Api\Model\AreaDetail[]
     */
    public function getAreaDetails()
    {
        return $this->container['areaDetails'];
    }

    /**
     * Sets areaDetails
     *
     * @param \Metatavu\Pakkasmarja\Api\Model\AreaDetail[] $areaDetails
     *
     * @return $this
     */
    public function setAreaDetails($areaDetails)
    {
        $this->container['areaDetails'] = $areaDetails;

        return $this;
    }

    /**
     * Gets deliverAll
     *
     * @return bool
     */
    public function getDeliverAll()
    {
        return $this->container['deliverAll'];
    }

    /**
     * Sets deliverAll
     *
     * @param bool $deliverAll
     *
     * @return $this
     */
    public function setDeliverAll($deliverAll)
    {
        $this->container['deliverAll'] = $deliverAll;

        return $this;
    }

    /**
     * Gets status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     *
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $allowedValues = $this->getStatusAllowableValues();
        if (!is_null($status) && !in_array($status, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'status', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->container['remarks'];
    }

    /**
     * Sets remarks
     *
     * @param string $remarks
     *
     * @return $this
     */
    public function setRemarks($remarks)
    {
        $this->container['remarks'] = $remarks;

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


