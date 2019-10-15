<?php
namespace Humm\HummPaymentGateway\Model;
 
class Type implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '', 'label' => __('Little & Big Things')],
            ['value' => '&LittleOnly', 'label' => __('Little Things Only')],
            ['value' => '&BigOnly', 'label' => __('Big Things Only')]
        ];
    }
}