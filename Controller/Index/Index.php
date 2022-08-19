<?php
namespace Hcl\Subscription\Controller\Index;

use Hcl\Subscription\Helper\Data as DataHelper;
use Hcl\Subscription\Helper\Send as SendHelper;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Hcl\Subscription\Helper\Send
     */
    protected $sendhelper;

    /**
     * @var Hcl\Subscription\Helper\Data
     */
    protected $datahelper;

     /**
      * @param Context $context
      * @param SendHelper $sendhelper
      * @param DataHelper $datahelper
      */
    public function __construct(
        Context $context,
        SendHelper $sendhelper,
        DataHelper $datahelper
    ) {
        $this->sendhelper = $sendhelper;
        $this->datahelper = $datahelper;
        return parent::__construct($context);
    }

    public function execute()
    {
        for ($i=0; $i < 4; $i++) {
            $toDate = $this->datahelper->calculateSubscriptionEndDate('+', false, $i);
            $this->sendhelper->subscriptionCollection($i, $toDate);
        }
    }
}
