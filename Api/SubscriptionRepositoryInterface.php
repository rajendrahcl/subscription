<?php
declare(strict_types=1);

namespace Hcl\Subscription\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SubscriptionRepositoryInterface
{

    /**
     * Save Subscription
     * @param \Hcl\Subscription\Api\Data\SubscriptionInterface $subscription
     * @return \Hcl\Subscription\Api\Data\SubscriptionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Hcl\Subscription\Api\Data\SubscriptionInterface $subscription
    );

    /**
     * Retrieve Subscription
     * @param string $subscriptionId
     * @return \Hcl\Subscription\Api\Data\SubscriptionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($subscriptionId);

    /**
     * Retrieve Subscription matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Hcl\Subscription\Api\Data\SubscriptionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Subscription
     * @param \Hcl\Subscription\Api\Data\SubscriptionInterface $subscription
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Hcl\Subscription\Api\Data\SubscriptionInterface $subscription
    );

    /**
     * Delete Subscription by ID
     * @param string $subscriptionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($subscriptionId);
}
