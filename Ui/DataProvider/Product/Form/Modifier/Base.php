<?php
namespace Hcl\Subscription\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Field;

class Base extends AbstractModifier
{
   /**
    * @var array
    */
    protected $meta = [];

   /**
    * {@inheritdoc}
    */
    public function modifyData(array $data)
    {
        return $data;
    }

   /**
    * {@inheritdoc}
    */
    public function modifyMeta(array $meta)
    {
        $this->meta = $meta;

        $this->addFields();

        return $this->meta;
    }

   /**
    * Adds fields to the meta-data
    */
    protected function addFields()
    {
        $groupCustomOptionsName    = CustomOptions::GROUP_CUSTOM_OPTIONS_NAME;
        $optionContainerName       = CustomOptions::CONTAINER_OPTION;
        $commonOptionContainerName = CustomOptions::CONTAINER_COMMON_NAME;

        // Add fields to the values
        $this->meta[$groupCustomOptionsName]['children']['options']['children']['record']['children']
        [$optionContainerName]['children']['values']['children']['record']['children'] = array_replace_recursive(
            $this->meta[$groupCustomOptionsName]['children']['options']['children']['record']['children']
            [$optionContainerName]['children']['values']['children']['record']['children'],
            $this->getValueFieldsConfig()
        );
    }

   /**
    * The custom option fields config
    *
    * @return array
    */
    protected function getValueFieldsConfig()
    {
        $fields['custom_option_hcl_subscription_days'] = $this->getHclSubscriptionDaysFieldConfig();

        return $fields;
    }

   /**
    * Get custom_option_hcl_subscription_days field config
    *
    * @return array
    */
    protected function getHclSubscriptionDaysFieldConfig()
    {
        return [
           'arguments' => [
               'data' => [
                   'config' => [
                       'label' => __('Subscription Days'),
                       'componentType' => Field::NAME,
                       'formElement'   => Input::NAME,
                       'dataType'      => Text::NAME,
                       'dataScope'     => 'custom_option_hcl_subscription_days',
                       'sortOrder'     => 41
                   ],
               ],
           ],
        ];
    }
}
