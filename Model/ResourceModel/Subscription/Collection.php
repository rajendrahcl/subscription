<?php
declare(strict_types=1);

namespace Hcl\Subscription\Model\ResourceModel\Subscription;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'subscription_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Hcl\Subscription\Model\Subscription::class,
            \Hcl\Subscription\Model\ResourceModel\Subscription::class
        );
    }
}
