<?php
namespace Hcl\Subscription\Observer;

use Magento\Framework\Event\ObserverInterface;

class SetItemCustomAttribute implements ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    const IS_SUBSCRIPTION_PRODUCT = 0;

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();
        
        $isSubscriptionProduct = self::IS_SUBSCRIPTION_PRODUCT;

        if ($product->getData('hcl_subscription')) {
            $isSubscriptionProduct = $product->getData('hcl_subscription');
        }
        $quoteItem->setHclSubscription($isSubscriptionProduct);
    }
}
