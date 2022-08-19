<?php
declare(strict_types=1);

namespace Hcl\Subscription\Api\Data;

interface SubscriptionInterface
{
    const SUBSCRIPTION_ID = 'subscription_id';
    const CUSTOMER_NAME = 'customer_name';
    const CUSTOMER_EMAIL = 'customer_email';
    const ORDER_ID = 'order_id';
    const ORDER_INCREMENT_ID = 'order_increment_id';
    const PRODUCT_ID = 'product_id';
    const PRODUCT_NAME = 'product_name';
    const PRODUCT_AMOUNT = 'product_amount';
    const STATE = 'state';
    const STATUS = 'status';
    const SUBSCRIPTION = 'subscription';
    const DURATION = 'duration';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get subscription_id
     * @return string|null
     */
    public function getSubscriptionId();

    /**
     * Set subscription_id
     * @param string $subscriptionId
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setSubscriptionId($subscriptionId);

    /**
     * Get customer_name
     * @return string|null
     */
    public function getCustomerName();

    /**
     * Set subscription_id
     * @param string $subscription_id
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setCustomerName($subscription_id);

    /**
     * Get customer_email
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer_email
     * @param string $customer_email
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setCustomerEmail($customer_email);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $order_id
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setOrderId($order_id);

    /**
     * Get order_increment_id
     * @return string|null
     */
    public function getOrderIncrementId();

    /**
     * Set order_increment_id
     * @param string $order_increment_id
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setOrderIncrementId($order_increment_id);

     /**
      * Get product_id
      * @return int|null
      */
    public function getProductId();

    /**
     * Set product_id
     * @param int $product_id
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setProductId($product_id);

    /**
     * Get product_name
     * @return string|null
     */
    public function getProductName();

    /**
     * Set product_name
     * @param string $product_name
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setProductName($product_name);

    /**
     * Get product_amount
     * @return string|null
     */
    public function getProductAmount();

    /**
     * Set product_amount
     * @param string $product_amount
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setProductAmount($product_amount);

    /**
     * Get state
     * @return string|null
     */
    public function getState();

    /**
     * Set state
     * @param string $state
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setState($state);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setStatus($status);

    /**
     * Get subscription
     * @return string|null
     */
    public function getSubscription();

    /**
     * Set subscription
     * @param string $subscription
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setSubscription($subscription);

    /**
     * Get duration
     * @return DateTime|null
     */
    public function getDuration();

    /**
     * Set duration
     * @param DateTime $duration
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setDuration($duration);

    /**
     * Get start_date
     * @return string|null
     */
    public function getStartDate();

    /**
     * Set start_date
     * @param string $start_date
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setStartDate($start_date);

    /**
     * Get end_date
     * @return DateTime|null
     */
    public function getEndDate();

    /**
     * Set end_date
     * @param DateTime $end_date
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setEndDate($end_date);

    /**
     * Get created_at
     * @return DateTime|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param DateTime $created_at
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setCreatedAt($created_at);

    /**
     * Get updated_at
     * @return DateTime|null
     */
    public function getUpdatedAt();

    /**
     * Set created_at
     * @param DateTime $updated_at
     * @return \Hcl\Subscription\Subscription\Api\Data\SubscriptionInterface
     */
    public function setUpdatedAt($updated_at);
}
