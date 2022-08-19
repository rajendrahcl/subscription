<?php
declare(strict_types=1);

namespace Hcl\Subscription\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Bundle\Api\ProductOptionRepositoryInterface;

class Data extends AbstractHelper
{
    /**
     * @var \Hcl\Subscription\Model\SubscriptionFactory
     */
    protected $subsctiption;

    /**
     * @var \Magento\Sales\Api\Data\OrderInterface
     */
    protected $order;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @var ProductOptionRepositoryInterface
     */
    protected $productOptionRepositoryInterface;

    /**
     * @var Option
     */
    protected $customOption;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Hcl\Subscription\Model\SubscriptionFactory $subsctiption,
        \Magento\Sales\Api\Data\OrderInterface $order,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        ProductRepositoryInterface $productRepositoryInterface,
        ProductOptionRepositoryInterface $productOptionRepositoryInterface,
        \Magento\Catalog\Model\Product\Option $customOption
    ) {
        parent::__construct($context);
        $this->subsctiption                     = $subsctiption;
        $this->order                            = $order;
        $this->date                             = $date;
        $this->productRepositoryInterface       = $productRepositoryInterface;
        $this->productOptionRepositoryInterface = $productOptionRepositoryInterface;
        $this->customOption                     = $customOption;
    }

    /**
     * @ Sink Realtime subscription data for subscription order
     */
    public function saveHclSubscriptionForOrder($orderIds = null)
    {
        if ($orderIds) {
            $order =  $this->getOrder($orderIds);
            if ($order) {
                $customerName       = $order->getCustomerFirstname()." ".$order->getCustomerLastname();
                $customerEmail      = $order->getCustomerEmail();
                $IncrementOrderId   = $order->getIncrementId();
                $orderId            = $order->getId();
                $state              = $this->getSubscriptionState($order->getStatus());
                $Status             = $this->getSubscriptionStatus($order->getStatus());

                $orderItems         = $this->getSubscriptionOrderItems($order);
                if (count($orderItems) > 0) {
                    foreach ($orderItems as $orderItem) {
                        /**
                         * Set subscription data for Hcl Subscription
                         */
                        $subsctiption = $this->subsctiption->create();
                        $subsctiption->setCustomerName($customerName);
                        $subsctiption->setCustomerEmail($customerEmail);
                        $subsctiption->setOrderId($orderId);
                        $subsctiption->setOrderIncrementId($IncrementOrderId);

                        if (isset($orderItem['name'])) {
                            $subsctiption->setProductName($orderItem['name']);
                        }
                        if (isset($orderItem['product_id'])) {
                            $subsctiption->setProductId($orderItem['product_id']);
                        }

                        if (isset($orderItem['base_price'])) {
                            $subsctiption->setProductAmount($orderItem['base_price']);
                        }

                        if (isset($orderItem['product_options'])) {
                            $subsctiption->setSubscription($orderItem['product_options']);
                        }

                        if (isset($orderItem['start_date'])) {
                            $subsctiption->setStartDate($orderItem['start_date']);
                        }

                        if (isset($orderItem['end_date'])) {
                            $subsctiption->setEndDate($orderItem['end_date']);
                        }

                        if (isset($orderItem['duration'])) {
                            $subsctiption->setDuration($orderItem['duration']);
                        }

                        $subsctiption->setState($state);
                        $subsctiption->setStatus($Status);

                        $subsctiption->save();
                    }
                }
            }
        }
    }

    /**
     * @Get Subscription Order
     * @return object
     */
    private function getOrder($orderIds = null)
    {
        if ($orderIds) {
            return $this->order->load($orderIds);
        }
        return null;
    }

    /**
     * @Get Subscription Order Items
     */
    private function getSubscriptionOrderItems($order = null)
    {
        $items = [];
        $orerItems = $order->getAllVisibleItems();

        foreach ($orerItems as $item) {
            if ($item->getData('hcl_subscription') == '1') {
                $product = $this->getProductDataByProductId($item->getData('product_id'));

                $data       = [];
                $data['product_id']         = $item->getData('product_id');
                $data['item_id']            = $item->getData('item_id');
                $data['order_id']           = $item->getData('order_id');
                $data['store_id']           = $item->getData('store_id');
                $data['created_at']         = $item->getData('created_at');
                $data['created_at']         = $item->getData('created_at');
                $data['updated_at']         = $item->getData('updated_at');
                $data['name']               = $item->getData('name');
                $data['skus']               = $item->getData('sku');
                $data['sku']                = $product->getSku();
                $data['is_virtual']         = $item->getData('is_virtual');
                $data['qty_ordered']        = $item->getData('qty_ordered');
                $data['base_price']         = $item->getData('base_price');
                $data['hcl_subscription']   = $item->getData('hcl_subscription');
                $data['product_type']       = $item->getData('product_type');
                $data['start_date']         = $this->calculateSubscriptionStartDate();

                $data['product_options']    = $this->getProductOptions(
                    $item->getData('product_type'),
                    $item->getData('product_options')
                );

                $hclSubscriptionDaysData    = $this->getSubscriptionEndDate(
                    $product,
                    $item->getData('product_type'),
                    $item->getData('product_options')
                );
                $end_date = $hclSubscriptionDaysData['end_date'];
                $duration = $hclSubscriptionDaysData['duration'];
                $data['end_date']      = isset($end_date) ? $end_date : '';
                $data['duration']      = isset($duration) ? $duration : '';

                $items[] = $data;
            }
        }

        return $items;
    }

    private function getProductOptions($productType = null, $productOptions = null)
    {
        $optionData = '';

        /**
         * @Manage Simple Product Options
         */
        if ($productType == 'simple' || $productType == 'virtual') {
            if (count($productOptions) > 0) {
                if (isset($productOptions['info_buyRequest']) && isset($productOptions['info_buyRequest']['options'])) {
                    $infoOption = $productOptions['info_buyRequest']['options'];
                    if (count($infoOption) > 0) {
                        if (isset($productOptions['options']) && count($productOptions['options']) > 0) {
                            $proOptions = $productOptions['options'];
                            foreach ($proOptions as $op) {
                                if (trim($optionData) != "") {
                                    $optionData .=  ' || ';
                                }
                                $optionData .=  $op['label'].": ".$op['value'];
                            }
                        }
                    }
                }
            }
        }
        
        /**
         * @Manage Bundle Product Options
         */

        if ($productType == 'bundle') {
            if (count($productOptions) > 0) {
                $bundle_option = $productOptions['info_buyRequest']['bundle_option'];
                if (isset($productOptions['info_buyRequest']) && isset($bundle_option)) {
                    $infoOption = $productOptions['info_buyRequest']['bundle_option'];
                    if (count($infoOption) > 0) {
                        if (isset($productOptions['bundle_options']) && count($productOptions['bundle_options']) > 0) {
                            $proOptions = $productOptions['bundle_options'];
                            foreach ($proOptions as $op) {
                                if (trim($optionData) != "") {
                                    $optionData .=  ' || ';
                                }
                                $optionValue = isset($op['value'][0]['title']) ? $op['value'][0]['title'] : '';
                                $optionData .=  $op['label'].": ".$optionValue;
                            }
                        }
                    }
                }
            }
        }
        return $optionData;
    }

    private function getSubscriptionEndDate($product = null, $productType = null, $productOptions = null)
    {
        $data    = [];
         /**
         * @Manage Simple Product Options
         */
        if ($productType == 'simple' || $productType == 'virtual') {
            if (count($productOptions) > 0) {
                if (isset($productOptions['info_buyRequest']) && isset($productOptions['info_buyRequest']['options'])) {
                    $infoOption = $productOptions['info_buyRequest']['options'];
                    if (count($infoOption) > 0) {
                        foreach ($infoOption as $key => $value) {
                            $data = $this->getSimpleProductOptionsData($product, $key, $value);
                        }
                    }
                }
            }
        }

        /**
         * @Manage Bundle Product Options
         */
        if ($productType == 'bundle') {
            if (count($productOptions) > 0) {
                $bundle_option = $productOptions['info_buyRequest']['bundle_option'];
                $info_buyRequest = $productOptions['info_buyRequest'];
                if (isset($info_buyRequest) && isset($bundle_option)) {
                    $infoOption = $productOptions['info_buyRequest']['bundle_option'];

                    if (count($infoOption) > 0) {
                        if (isset($productOptions['bundle_options']) && count($productOptions['bundle_options']) > 0) {
                            $proOptions = $productOptions['bundle_options'];
                            $selectedOptionId = 0;
                            foreach ($proOptions as $op) {

                                $optionId = $op['option_id'];

                                if (isset($infoOption[$optionId]) && $infoOption[$optionId] > 0) {
                                    if (is_array($infoOption[$optionId])) {
                                        foreach ($infoOption[$optionId] as $keyId => $valueId) {
                                            $selectedOptionId = $valueId;
                                        }
                                    } else {
                                        $selectedOptionId = $infoOption[$optionId];
                                    }
                                }
                                $sku = $product->getSku();
                                $data = $this->getBundleProductOptionsData($sku, $optionId, $selectedOptionId);
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @ Get Product sku using product_id
     */
    private function getProductDataByProductId($productId = null)
    {
        return $this->productRepositoryInterface->getById($productId);
    }

    /**
     * @ Get bundle product with option details
     */
    private function getBundleProductOptions($sku = null, $optionId = null)
    {
        return $this->productOptionRepositoryInterface->get($sku, $optionId);
    }

    /**
     * @Calculate end_date and start_date for Bundle product options
     * @load simple product for bundle prodcut options
     * @get hcl_subscription_days attrubute value from virtual and simple products
     */
    private function getBundleProductOptionsData($sku = null, $optionId = null, $selectedOptionId = null)
    {
        $data   = [];
        $endDate = '';
        $hclSubscriptionDays = 0;

        $bundleProductOptions = $this->getBundleProductOptions($sku, $optionId);

        if ($bundleProductOptions->getProductLinks()) {
            foreach ($bundleProductOptions->getProductLinks() as $pOptions) {
                if ($pOptions['id'] == $selectedOptionId) {
                    $product = $this->getProductDataByProductId($pOptions['entity_id']);
                    if ($product->getHclSubscriptionDays()) {
                        $hclSubscriptionDays = $product->getHclSubscriptionDays();
                        if ($hclSubscriptionDays > 0) {
                            $endDate = $this->calculateSubscriptionEndDate($hclSubscriptionDays, '+');
                        }
                    }
                }
            }
        }
        $data['duration'] = $hclSubscriptionDays." days";
        $data['end_date'] = $endDate;

        return $data;
    }

    /**
     * @param string $sku
     * @return \Magento\Catalog\Api\Data\ProductCustomOptionInterface[]
     */
    private function getSimpleProductOptionsData($product = null, $optionId = null, $selectedOptionId = null): array
    {
        $data    = [];
        $endDate = '';
        $hclSubscriptionDays = 0;
        $customOptions =  $this->customOption->getProductOptionCollection($product);

        foreach ($customOptions as $customOption) {
            if ($customOption->getData('option_id') == $optionId) {
                if (count($customOption->getValues()) > 0) {
                    $SubData = $this->getDurationandEnddate($customOption->getValues(), $selectedOptionId);
                }
            }
        }

        $data['duration'] = $SubData['hclSubscriptionDays']." days";
        $data['end_date'] = $SubData['endDate'];

        return $data;
    }

    /**
     * Get Subscription End Date and Durations
     * @return array
     */
    private function getDurationandEnddate($customOptionValues, $selectedOptionId)
    {
        $data    = [];
        foreach ($customOptionValues as $value) {
            if ($value->getData('option_type_id') == $selectedOptionId) {
                $hclSubscriptionDays = $value->getData('custom_option_hcl_subscription_days');
                $data['hclSubscriptionDays'] = $hclSubscriptionDays;
                if ($hclSubscriptionDays > 0) {
                    $data['endDate'] = $this->calculateSubscriptionEndDate($hclSubscriptionDays, '+');
                }
            }
        }
        return $data;
    }

    /**
     * Get Subscription state key
     * @return int
     */
    public function getSubscriptionState($state = null)
    {
        $stateArray = array_flip($this->getState());
        if ($state) {
            if (isset($stateArray[$state])) {
                return $stateArray[$state];
            }
        }
        return 0;
    }

    /**
     * Get Subscription status key
     * @return bool
     */
    private function getSubscriptionStatus($status = null)
    {
        if ($status) {
            if (($status == 'pending') || ($status == 'processing') || ($status == 'complete')) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * Get Subscription state for products\
     * @return time
     */
    public function getState()
    {
        $data     =   [];
        $data[0]  =   'pending';
        $data[1]  =   'processing';
        $data[2]  =   'complete';
        $data[3]  =   'cancel';

        return($data);
    }

    /**
     * Get Subscription status for products
     * @return array
     */
    public function getStatus()
    {
        $data     =   [];
        $data[0]  =   'disable';
        $data[1]  =   'enable';

        return($data);
    }

    /**
     * Calculate Subscription Start Date
     * @return time
     */
    public function calculateSubscriptionStartDate($isTime = true)
    {
        $time = '';
        if ($isTime != false) {
            $time = ' H:i:s';
        }
        return $this->date->date('Y-m-d'.$time);
    }

    /**
     * @ Calculate Subscription End Date
     * @return datetime
     */
    public function calculateSubscriptionEndDate($operator, $isTime = true, $day = 0)
    {
        $date = $this->calculateSubscriptionStartDate();
        $time = '';
        if ($isTime != false) {
            $time = ' H:i:s';
        }
        $nextdate = $this->date->date('Y-m-d '.$time, strtotime($date." ".$operator.$day." days"));
        return $nextdate;
    }
}
