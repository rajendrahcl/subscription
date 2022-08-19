<?php
declare(strict_types=1);

namespace Hcl\Subscription\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * System config "section/group"
     */
    const CONFIG_GROUP = 'hcl_subscription/general/';

    /**
     * System config "value"
     */
    const CONFIG_MODULE_ENABLE = 'enable';
    const CONFIG_SENDER_EMAIL = 'subscription_email';
    const CONFIG_SENDER_NAME = 'subscription_customer';

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return System config value
     */
    private function getConfigValue($config_value)
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_GROUP.$config_value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getConfigValue(self::CONFIG_MODULE_ENABLE);
    }

    /**
     * @return bool
     */
    public function senderEmail()
    {
        return $this->getConfigValue(self::CONFIG_SENDER_EMAIL);
    }

    /**
     * @return bool
     */
    public function senderName()
    {
        return $this->getConfigValue(self::CONFIG_SENDER_NAME);
    }
}
