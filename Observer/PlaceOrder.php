<?php
namespace Hcl\Subscription\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteFactory;

class Placeorder implements ObserverInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $quoteFactory;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Quote\Model\QuoteFactory $quoteFactory
    ) {
        $this->_logger = $logger;
        $this->quoteFactory =   $quoteFactory;
    }

    public function execute(Observer $observer)
    {
        $order      = $observer->getOrder();
        $quoteId    = $order->getQuoteId();
        $quote      = $this->quoteFactory->create()->load($quoteId);

        if ($quote->getHclSubscription()) {
            $order->setHclSubscription($quote->getHclSubscription());
            $order->save();
        }
    }
}
