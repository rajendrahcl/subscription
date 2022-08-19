<?php
namespace Hcl\Subscription\Observer;

use Psr\Log\LoggerInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ResourceConnection;
use Hcl\Subscription\Api\SubscriptionRepositoryInterface;
use Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory;
use Hcl\Subscription\Helper\Data as SubscriptionHelperData;
use Magento\Framework\Event\Observer;

class OrderSaveAfter implements ObserverInterface
{
    /**
     * @var Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @var Hcl\Subscription\Api\SubscriptionRepositoryInterface
     */
    protected $subscriptionRepository;

    const TABLE_NAME = 'hcl_subscription_subscription';

    /**
     * @var Hcl\Subscription\Api\SubscriptionRepositoryInterface
     */
    protected $collectionFactory;

    const STATUS_PROCESSING = 'processing';

    /**
     * @param LoggerInterface $logger
     * @param ResourceConnection $resource
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     * @param CollectionFactory $collectionFactory
     * @param SubscriptionHelperData $dataHelper
     */
    public function __construct(
        LoggerInterface $logger,
        ResourceConnection $resource,
        SubscriptionRepositoryInterface $subscriptionRepository,
        CollectionFactory $collectionFactory,
        SubscriptionHelperData $dataHelper
    ) {
        $this->logger = $logger;
        $this->resource = $resource;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->collectionFactory = $collectionFactory;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Update subscription status and state on order update
     * @param object
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        if ($order->getHclSubscription()) {
            $collection =  $this->collectionFactory->create()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('order_id', ['eq' => $order->getId()]);
            
            if ($collection->getSize()) {
                $connection = $this->resource->getConnection();
                $tableName     = $this->resource->getTableName(self::TABLE_NAME);
                $state     =      $this->dataHelper->getSubscriptionState($order->getStatus());
                $status =     $this->mapStatus($state);
                foreach ($collection as $subscription) {
                    if ($subscription->getData('subscription_id')) {
                        $subacriptionId = $subscription->getSubscriptionId();
                        $this->subscriptionUpdate($subacriptionId, $tableName, $connection);
                    }
                }
            }
        }
    }

    /**
     * Update subscription status and state on order update
     * @param int
     */
    private function subscriptionUpdate($subacriptionId, $tableName, $connection)
    {
        if ($subacriptionId) {
            $where = ['subscription_id = '.$subacriptionId];
            $data = ['status'     => '1', 'state'    => '2'];
            try {
                $connection->update($tableName, $data, $where);
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }

    /**
     * @return bool
     */
    private function mapStatus($state = '')
    {
        if ($state == 3) {
            return 0;
        }
          return 1;
    }
}
