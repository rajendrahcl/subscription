<?php
declare(strict_types=1);

namespace Hcl\Subscription\Block\Customer;

use Magento\Framework\ObjectManagerInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Theme\Block\Html\Pager;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $object;

    /**
     * @var \Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory
     */
    protected $subsctiption;
    
    /**
     * @var \Hcl\Subscription\Helper\Data
     */
    protected $helper;

    /**
     * @var Hcl/Subscription email field
     */
    const CUSTOMER_EMAIL = 'customer_email';

    const SORTING_LIST = 'asc';  // desc

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory $collectionFactory,
        \Hcl\Subscription\Helper\Data $helper,
        ObjectManagerInterface $interface,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory  = $collectionFactory;
        $this->object = $interface;
        $this->helper = $helper;
    }

    /**
     * @Prepare Layout for subscription grid with pagination
     * */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($this->getSubscriptionData()) {
            $pager = $this->getLayout()->createBlock(
                Pager,
                'hcl-subscription-custom'
            )->setAvailableLimit([10=>10,20=>20,50=>50])
                ->setShowPerPage(true)->setCollection(
                    $this->getSubscriptionData()
                );
            $this->getSubscriptionData()->load();
            $this->setChild('pager', $pager);
        }
        return $this;
        // return parent::_prepareLayout();
    }

    /**
     * @pagination
     * */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @return currect customer Email
     * */
    public function getCustomerEmail()
    {
        return $this->object->create(SessionFactory)->create()->getCustomer()->getEmail();
    }

    /**
     * @return HclSubscription Data for currect customer
     * */
    public function getSubscriptionData()
    {
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest(
        )->getParam('limit') : 12;

        $subscription =  $this->collectionFactory->create()
                        ->addFieldToSelect('*')
                        ->addFieldToFilter(
                            self::CUSTOMER_EMAIL,
                            ['eq' => $this->getCustomerEmail()]
                        )
                        ->setOrder(
                            'created_at',
                            self::SORTING_LIST
                        );

        $subscription->setPageSize($pageSize);
        $subscription->setCurPage($page);

        return $subscription;
    }

    /**
     * Get order view URL
     *
     * @param object $orderId
     * @return string
     */
    public function getViewUrl($orderId)
    {
        return $this->getUrl('sales/order/view', ['order_id' => $orderId]);
    }

    /**
     * Get reorder URL
     *
     * @param object $orderId
     * @return string
     */
    public function getReorderUrl($orderId)
    {
        return $this->getUrl('sales/order/reorder', ['order_id' => $orderId]);
    }

    /**
     * Get Product URL
     *
     * @param object $productId
     * @return string
     */
    public function getProductUrl($productId)
    {
        return $this->getUrl('catalog/product/view', ['id' => $productId]);
    }

    /**
     * Get Subscription order status
     *
     * @param object $status
     * @return string
     */
    public function getStatus($status)
    {
        $statusData =  $this->helper->getStatus();
        if (isset($statusData[$status])) {
            return $statusData[$status];
        }
        return $status;
    }
}
