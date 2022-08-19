<?php

namespace Hcl\Subscription\Cron;

use Hcl\Subscription\Helper\Data as DataHelper;
use Hcl\Subscription\Helper\Send as SendHelper;

class Subscription
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
      * @param SendHelper $sendhelper
      * @param DataHelper $datahelper
      */
    public function __construct(
        SendHelper $sendhelper,
        DataHelper $datahelper
    ) {
        $this->sendhelper = $sendhelper;
        $this->datahelper = $datahelper;
    }

    public function execute()
    {
        for ($i=0; $i < 4; $i++) {
            $toDate = $this->datahelper->calculateSubscriptionEndDate('+', false, $i);
            $this->sendhelper->subscriptionCollection($i, $toDate);
        }
    }
}
