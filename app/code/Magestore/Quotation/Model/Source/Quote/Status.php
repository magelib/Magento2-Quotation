<?php

/**
 * Copyright © 2018 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magestore\Quotation\Model\Source\Quote;

/**
 * Class Status
 * @package Magestore\Quotation\Model\Source\Quote
 */
class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    const STATUS_NONE = 0;
    const STATUS_PENDING = 1;
    const STATUS_NEW = 2;
    const STATUS_PROCESSING = 3;
    const STATUS_PROCESSED = 4;
    const STATUS_DECLINED = 5;
    const STATUS_EXPIRED = 6;
    const STATUS_ORDERED = 7;
    const STATUS_ADMIN_PENDING = 8;

    const LABEL_ADMIN_PENDING = "Admin Creating";

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('New'), 'value' => self::STATUS_NEW],
            ['label' => __('Processing'), 'value' => self::STATUS_PROCESSING],
            ['label' => __('Processed'), 'value' => self::STATUS_PROCESSED],
            ['label' => __('Declined'), 'value' => self::STATUS_DECLINED],
            ['label' => __('Expired'), 'value' => self::STATUS_EXPIRED],
            ['label' => __('Ordered'), 'value' => self::STATUS_ORDERED]
        ];
    }

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::STATUS_NEW => __('New'),
            self::STATUS_PROCESSING => __('Processing'),
            self::STATUS_PROCESSED => __('Processed'),
            self::STATUS_DECLINED => __('Declined'),
            self::STATUS_EXPIRED => __('Expired'),
            self::STATUS_ORDERED => __('Ordered')
        ];
    }

}