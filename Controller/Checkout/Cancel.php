<?php

namespace Humm\HummPaymentGateway\Controller\Checkout;

use Magento\Framework\App\Action\Context;


/**
 * Roger.bi@flexigroup.com.au
 * @package Humm\HummPaymentGateway\Controller\Checkout
 */
class Cancel extends AbstractAction
{

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $orderId = $this->getRequest()->get('orderId');
        $order = $orderId ? $this->getOrderById($orderId) : false;
        $this->getHummLogger()->log('Requested order cancellation by customer. OrderId&QuoteId: ' . $order->getId() . $order->getQuoteId());
        try {
            $this->_eventManager->dispatch('humm_payment_cancel', ['order' => $order, 'type' => 'button']);
            if ($order->getAppliedRuleIds()) {
                $this->_eventManager->dispatch('humm_payment_coupon_cancel', ['order' => $order, 'type' => 'coupon']);
            }
            $this->getHummLogger()->log(sprintf('Begin Cancel: [Order Id: %s] for humm_payment_cancel info and humm_payment_coupon_cancel' , $orderId));
            $this->getMessageManager()->addWarningMessage(__("You have cancelled your humm payment. Please Check"));
        } catch (\Exception $e) {
            $this->getHummLogger()->log('humm_payment_cancel_error or humm_payment_coupon_cancel' . $orderId);
            $this->getMessageManager()->addWarningMessage(__("Cancelled order error. Please Check Order"));

        }
        $this->_redirect('humm/checkout/error');
    }
}
