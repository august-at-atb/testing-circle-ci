<?php

namespace App\Services\ShipStation\Json;

use App\Contracts\Interfaces\BuilderInterface;
use App\Services\ShipStation\Json\JsonBuilderHelper;

class JsonBuilder implements BuilderInterface
{
    protected $buildHelper;

    public function __construct(JsonBuildHelper $buildHelper)
    {
        $this->buildHelper = $buildHelper;
    }

    private function _build($orderId)
    {
        $order = $this->buildHelper->getOrder($orderId);
        $orderItems = $this->buildHelper->getOrderItems($orderId);
        $billingAddress = $this->buildHelper->getAddress($order->getBillingAddressId());
        $shippingAddress = $this->buildHelper->getAddress($order->getShippingAddressId());
        $orderStatus = $this->buildHelper->getOrderStatus($order->getStatus());

        $advancedOptions = array('storeId' => config('services.shipstation.store'),
                                 'customField1' => $order->getVolume(),
                                 'customField2' => $order->getCouponCode());

        $orderDate = date('Y-m-d H:i:s', strtotime($order->getOrderDate()) - 8 * 3600);

        $shipmentData = array('orderNumber' => $order->getOrderNumber(),
                              'orderKey' => $order->getOrderNumber(),
                              'orderDate'  => $orderDate,
                              'orderStatus' => $orderStatus,
                              'customerEmail' => $order->getEmail(),
                              'billTo' => $billingAddress,
                              'shipTo' => $shippingAddress,
                              'items' => $orderItems,
                              'amountPaid' => $order->getGrandTotal(),
                              'taxAmount' => $order->getTaxAmount(),
                              'shippingAmount' => $order->getShippingAmount(),
                              'paymentMethod' => $order->getPaymentMethod(),
                              'requestedShippingService' => $order->getShippingMethod(),
                              'internalNotes' => '',
                              'advancedOptions' => $advancedOptions
                );

        return $shipmentData;
    }

    private function _formatJson($data)
    {
        $jsonData = json_encode($data);
        return $jsonData;
    }
}
