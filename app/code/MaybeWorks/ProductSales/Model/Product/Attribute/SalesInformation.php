<?php

namespace MaybeWorks\ProductSales\Model\Product\Attribute;

use Magento\Framework\Model\Context;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use MaybeWorks\ProductSales\Api\Data\SalesInformationInterface;
use MaybeWorks\ProductSales\Model\ResourceModel\Product\SalesInformationFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class SalesInformation
 *
 * @package MaybeWorks\ProductSales\Model\Product\Attribute
 */
class SalesInformation extends AbstractExtensibleModel implements SalesInformationInterface
{
    /** @var int */
    protected $productId;

    /** @var string */
    protected $orderStatus;

    /** @var SalesInformationFactory */
    protected $salesInformationFactory;

    /** @var int|null */
    private $salesQty = null;

    /** @var int|null */
    private $lastOrderDate = null;

    /**
     * SalesInformation constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param SalesInformationFactory $salesInformationFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param string $orderStatus
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        SalesInformationFactory $salesInformationFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        $orderStatus = '',
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
        $this->salesInformationFactory = $salesInformationFactory;
        $this->orderStatus = $orderStatus;
    }

    /**
     * @return int
     *
     * @throws LocalizedException
     */
    public function getQty()
    {
        if (is_null($this->salesQty)) {
            $this->salesQty = $this->salesInformationFactory->create()
                ->getProductSalesQty($this->getProductId());
        }
        return $this->salesQty;
    }

    /**
     * @return string
     *
     * @throws LocalizedException
     */
    public function getLastOrder()
    {
        if (is_null($this->lastOrderDate)) {
            $this->lastOrderDate = $this->salesInformationFactory->create()
                ->getProductLastOrderDate($this->getProductId(), $this->getOrderStatus());
        }
        return $this->lastOrderDate;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $id
     */
    public function setProductId($id)
    {
        $this->productId = $id;
    }

    /**
     * @return string
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }
}