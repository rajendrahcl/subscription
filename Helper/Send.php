<?php
declare(strict_types=1);

namespace Hcl\Subscription\Helper;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\ResourceConnection;
use Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory;
use Hcl\Subscription\Helper\Config as ConfigHelper;

class Send extends AbstractHelper
{
    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    
    /**
     * @var ResourceConnection
     */
    protected $resource;
    
    /**
     * @var ConfigHelper
     */
    protected $confighelper;

    const EMAIL_TEMPLATE = 'hcl_subscription_general_template';
    const EMAIL_TEMPLATE_NEW = 'hcl_subscription_general_neworder';
    const START_TIME = ' 00:00:00';
    const END_TIME = ' 23:59:59';
    const TABLE_NAME = 'hcl_subscription_subscription';

    /**
     * Data constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param LoggerInterface $logger
     * @param ResourceConnection $resource
     * @param ConfigHelper $confighelper
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        LoggerInterface $logger,
        ResourceConnection $resource,
        ConfigHelper $confighelper
    ) {
        $this->collectionFactory  = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->logger = $logger;
        $this->resource = $resource;
        $this->confighelper = $confighelper;
        parent::__construct($context);
    }

    public function subscriptionCollection($days, $toDate)
    {
        $subscription =  $this->collectionFactory->create()->addFieldToSelect('*');
        $subscription->addFieldToFilter('end_date', ['like' => '%' . $toDate . '%']);
        $subscription->addFieldToFilter('status', ['eq' =>  1]);
        $connection = $this->resource->getConnection();
        $tableName  = $this->resource->getTableName(self::TABLE_NAME);

        foreach ($subscription as $key => $subscriptionData) {
            if ($days == 0) {
                $this->subscriptionUpdate($subscriptionData->getData('subscription_id'), $tableName, $connection);
            } else {
                $this->sendMail($subscriptionData->getData(), $days, "expire");
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
            $where  = ['subscription_id = '.$subacriptionId];
            $data   = ['status' => '0', 'state' => '2'];
            try {
                $connection->update($tableName, $data, $where);
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }

    /**
     * Send Mail
     *
     * @return $this
     *
     * @throws LocalizedException
     * @throws MailException
     */
    public function sendMail($subscription, $days, $type)
    {
        $email = $subscription['customer_email']; //set receiver mail

        $this->inlineTranslation->suspend();
        $storeId = $this->getStoreId();
        
        /* email template */
        if ($type == "expire") {
            $template = self::EMAIL_TEMPLATE;
        } elseif ($type == "new") {
            $template = self::EMAIL_TEMPLATE_NEW;
        }
        
        $vars = [
            'subscription' => $subscription['subscription'],
            'days' => $days,
            'customer_name' => $subscription['customer_name'],
            'email' => $subscription['customer_email'],
            'order_id' => $subscription['order_id'],
            'order_increment_id' => $subscription['order_increment_id'],
            'plan_name' => $subscription['product_name'],
            'url' => $this->storeManager->getStore()->getBaseUrl()
        ];
      
        $this->transportBuilder->setTemplateIdentifier(
            $template
        )->setTemplateOptions(
            [
                'area' => Area::AREA_FRONTEND,
                'store' => $this->getStoreId()
            ]
        )->setTemplateVars(
            $vars
        )->setFrom(
            [
                'email' => $this->confighelper->senderEmail(),
                'name' => $this->confighelper->senderName(),
            ]
        )->addTo(
            $email
        );

        $transport = $this->transportBuilder->getTransport();
        
        try {
            $transport->sendMessage();
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
        $this->inlineTranslation->resume();

        return $this;
    }

    /**
     * get Current store id
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * get Current store Info
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }
}
