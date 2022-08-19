<?php
/**
 * Copyright © Hcl, Inc. All rights reserved.
 */

/**
 * Custom option price hide
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Hcl\Subscription\Block\Catalog\Product;

/**
 * Custom option price hide
 *
 */
class CustomOptionShow extends \Magento\Framework\View\Element\Template
{

    protected $_registry;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }
    
    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }
    
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function showCustomOptionPrice()
    {
        $isSubscribe = false;
        if ($this->getCurrentProduct()) {
            $currentProduct = $this->getCurrentProduct();
            if ($currentProduct->getData('hcl_subscription')) {
                $isSubscribe = true;
            }
        }

        return $isSubscribe;
    }
}
