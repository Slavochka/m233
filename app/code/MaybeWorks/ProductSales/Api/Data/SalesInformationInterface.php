<?php

namespace MaybeWorks\ProductSales\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Sales Information Interface
 *
 * @package MaybeWorks\ProductSales\Api\Data
 */
interface SalesInformationInterface extends ExtensibleDataInterface
{
    /**
     * Retrieve product's qty in orders
     *
     * @return int
     */
    public function getQty();

    /**
     * Retrieve last order date
     *
     * @return string
     */
    public function getLastOrder();

}