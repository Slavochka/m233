<?php

namespace MaybeWorks\ProductSales\Model\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class SalesInformation
 * @package MaybeWorks\ProductSales\Model\ResourceModel\Product
 */
class SalesInformation extends AbstractDb
{
    const QTY_COLUMN = 'qty_ordered';
    const DATE_COLUMN = 'created_at';

    /**
     * Define main table name
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sales_order_item', 'item_id');
    }

    /**
     * @param $productId
     *
     * @return int
     *
     * @throws LocalizedException
     */
    public function getProductSalesQty($productId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getMainTable(),
            ['SUM(`' . self::QTY_COLUMN . '`)']
        )->where(
            'product_id = ?',
            $productId
        );
        return $connection->fetchOne($select);
    }

    /**
     * @param int $productId
     * @param string $orderStatus
     *
     * @return string
     *
     * @throws LocalizedException
     */
    public function getProductLastOrderDate($productId, $orderStatus = '')
    {
        $connection = $this->getConnection();
        $select = $connection->select()->distinct()->from(
            $this->getMainTable(),
            [self::DATE_COLUMN]
        );
        if ($orderStatus) {
            $select->join(
                ['so' => $this->getTable('sales_order')],
                "{$this->getMainTable()}.order_id = so.entity_id",
                []
            )->where(
                "so.status = ?",
                $orderStatus
            );
        }
        $select->where(
            'product_id = ?',
            $productId
        )->order("{$this->getIdFieldName()} DESC");

        return $connection->fetchOne($select);
    }
}