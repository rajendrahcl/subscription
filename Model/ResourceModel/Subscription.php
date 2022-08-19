<?php
declare(strict_types=1);

namespace Hcl\Subscription\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Subscription extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('hcl_subscription_subscription', 'subscription_id');
    }
}
