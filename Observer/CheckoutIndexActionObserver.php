<?php
namespace Hcl\Subscription\Observer;
 
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session;

class CheckoutIndexActionObserver implements ObserverInterface
{

    /**
     * Checkout Session Model
     *
     * @var \Magento\Checkout\Model\Session $Session
     */
    protected $session;

    const IS_SUBSCRIPTION_PRODUCT = 0;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @Checkout Index Index Event
     * */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $isHclSubscription = self::IS_SUBSCRIPTION_PRODUCT;
        
        $quote = $this->session->getQuote();

        if ($quote->getAllVisibleItems()) {
            foreach ($quote->getAllVisibleItems() as $item) {
                if ($item->getData('hcl_subscription')) {
                    $isHclSubscription = $item->getData('hcl_subscription');
                }
            }
        }

        /**
         * @Set hcl_subscription attribute data in quote table as per quote items
         */
        if ($isHclSubscription > 0) {
            if (!$quote->getHclSubscription() || $quote->getHclSubscription() < 1) {
                $quote->setHclSubscription($isHclSubscription);
                $quote->save();
            }
        }
    }
}
