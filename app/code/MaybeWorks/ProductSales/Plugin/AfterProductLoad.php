<?php

namespace MaybeWorks\ProductSales\Plugin;

use MaybeWorks\ProductSales\Api\Data\SalesInformationInterface;
use Magento\Catalog\Api\Data\ProductExtension;
use Magento\Catalog\Model\Product;

/**
 * Class AfterProductLoad
 * @package MaybeWorks\ProductSales\Plugin
 */
class AfterProductLoad
{
    /** @var SalesInformationInterface */
    protected $salesInformation;

    /**
     * AfterProductLoad constructor.
     * @param SalesInformationInterface $salesInformation
     */
    public function __construct(
        SalesInformationInterface $salesInformation
    ) {
        $this->salesInformation = $salesInformation;
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function afterLoad(Product $product)
    {
        /** @var ProductExtension $productExtension */
        $productExtension = $product->getExtensionAttributes();
        $this->salesInformation->setProductId($product->getId());
        $productExtension->setSalesInformation($this->salesInformation);
        $product->setExtensionAttributes($productExtension);
        return $product;
    }
}
