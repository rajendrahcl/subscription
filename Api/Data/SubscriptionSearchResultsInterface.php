<?php
declare(strict_types=1);

namespace Hcl\Subscription\Api\Data;

interface SubscriptionSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Subscription list.
     * @return \Hcl\Subscription\Api\Data\SubscriptionInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \Hcl\Subscription\Api\Data\SubscriptionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
