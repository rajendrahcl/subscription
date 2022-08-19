<?php
declare(strict_types=1);

namespace Hcl\Subscription\Model;

use Hcl\Subscription\Api\Data\SubscriptionInterface;
use Hcl\Subscription\Api\Data\SubscriptionInterfaceFactory;
use Hcl\Subscription\Api\Data\SubscriptionSearchResultsInterfaceFactory;
use Hcl\Subscription\Api\SubscriptionRepositoryInterface;
use Hcl\Subscription\Model\ResourceModel\Subscription as ResourceSubscription;
use Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory as SubscriptionCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{

    /**
     * @var ResourceSubscription
     */
    protected $resource;

    /**
     * @var SubscriptionInterfaceFactory
     */
    protected $subscriptionFactory;

    /**
     * @var SubscriptionCollectionFactory
     */
    protected $subscriptionCollectionFactory;

    /**
     * @var Subscription
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param ResourceSubscription $resource
     * @param SubscriptionInterfaceFactory $subscriptionFactory
     * @param SubscriptionCollectionFactory $subscriptionCollectionFactory
     * @param SubscriptionSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceSubscription $resource,
        SubscriptionInterfaceFactory $subscriptionFactory,
        SubscriptionCollectionFactory $subscriptionCollectionFactory,
        SubscriptionSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionCollectionFactory = $subscriptionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(SubscriptionInterface $subscription)
    {
        try {
            $this->resource->save($subscription);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the subscription: %1',
                $exception->getMessage()
            ));
        }
        return $subscription;
    }

    /**
     * @inheritDoc
     */
    public function get($subscriptionId)
    {
        $subscription = $this->subscriptionFactory->create();
        $this->resource->load($subscription, $subscriptionId);
        if (!$subscription->getId()) {
            throw new NoSuchEntityException(__('Subscription with id "%1" does not exist.', $subscriptionId));
        }
        return $subscription;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->subscriptionCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(SubscriptionInterface $subscription)
    {
        try {
            $subscriptionModel = $this->subscriptionFactory->create();
            $this->resource->load($subscriptionModel, $subscription->getSubscriptionId());
            $this->resource->delete($subscriptionModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Subscription: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($subscriptionId)
    {
        return $this->delete($this->get($subscriptionId));
    }
}
