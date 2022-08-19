<?php
namespace Hcl\Subscription\Observer;
 
use Magento\Framework\Event\ObserverInterface;
 
class OrderObserver implements ObserverInterface
{
    /**
     * Hcl Helper
     *
     * @var \Hcl\Subscription\Helper\Data $hclHelper
     */
    protected $hclHelper;

    /**
     * Hcl Helper
     *
     * @var \Hcl\Subscription\Helper\Config $helperConfig
     */
    protected $helperConfig;

    public function __construct(
        \Hcl\Subscription\Helper\Data $hclHelper,
        \Hcl\Subscription\Helper\Config $helperConfig
    ) {
        $this->hclHelper = $hclHelper;
        $this->helperConfig = $helperConfig;
    }

    /**
     * @ Order Success Event
     * @ \Magento\Framework\Event\Observer $observer
     * */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $orderId = $observer->getEvent()->getOrderIds();

        if ($this->helperConfig->isEnabled() && $orderId) {
            $this->hclHelper->saveHclSubscriptionForOrder($orderId);
        }
    }
}
