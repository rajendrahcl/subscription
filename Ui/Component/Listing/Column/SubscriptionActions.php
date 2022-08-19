<?php
declare(strict_types=1);

namespace Hcl\Subscription\Ui\Component\Listing\Column;

class SubscriptionActions extends \Magento\Ui\Component\Listing\Columns\Column
{

    const URL_PATH_EDIT = 'hcl_subscription/subscription/edit';
    const URL_PATH_DELETE = 'hcl_subscription/subscription/delete';
    const URL_PATH_DETAILS = 'hcl_subscription/subscription/details';
    const URL_PATH_ORDER_VIEW = 'sales/order/view';
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['subscription_id'])) {
                    $item[$this->getData('name')] = [
                        'preview' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_ORDER_VIEW,
                                [
                                    'order_id' => $item['order_id']
                                ]
                            ),
                            'target' => '_blank',
                            'label' => __('View Order')
                        ]
                        , 'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'subscription_id' => $item['subscription_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ]
                        /*, 'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'subscription_id' => $item['subscription_id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                            ]
                        ]*/
                    ];
                }
            }
        }
        
        return $dataSource;
    }
}
