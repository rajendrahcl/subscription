<?php
namespace Hcl\Subscription\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesQuoteCollectTotals implements ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    const IS_SUBSCRIPTION_PRODUCT = 0;

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // fetch quote data
        /** @var Quote $quote */

        $quote = $observer->getEvent()->getQuote();

        $isSubscriptionProduct = self::IS_SUBSCRIPTION_PRODUCT;
        if (count($quote->getAllVisibleItems()) > 0) {
            foreach ($quote->getAllVisibleItems() as $items) {
                if ($items->getData('hcl_subscription') > 0) {
                    $isSubscriptionProduct = $items->getData('hcl_subscription');
                }
            }
        }
        /**
         * @Set hcl_subscription attribute data in quote table as per quote items
         */
        if ($isSubscriptionProduct > 0) {
            if (!$quote->getHclSubscription() || $quote->getHclSubscription() < 1) {
                $quote->setHclSubscription($isSubscriptionProduct);
                $quote->save();
            }
        }
    }
}
