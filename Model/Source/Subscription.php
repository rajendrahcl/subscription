<?php
/**
 * Copyright © Hcl, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hcl\Subscription\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Hcl Subscription
 *
 * @api
 * @since 100.0.2
 */

class Subscription implements OptionSourceInterface
{
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
        $res =  [
                    ['value' => 0, 'label' => 'No'],
                    ['value' => 1, 'label' => 'Yes'],
                ];

        return $res;
    }
}
