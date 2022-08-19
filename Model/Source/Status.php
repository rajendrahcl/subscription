<?php
/**
 * Copyright © Hcl, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hcl\Subscription\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Hcl Status
 *
 * @api
 * @since 100.0.2
 */
class Status implements OptionSourceInterface
{
    protected $helper;

    public function __construct(
        \Hcl\Subscription\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

     /**
      * Get product type labels array
      *
      * @return array
      */
    public function getOptionArray()
    {
        return $this->helper->getStatus();
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => ucfirst($value)];
        }
        return $res;
    }
}
