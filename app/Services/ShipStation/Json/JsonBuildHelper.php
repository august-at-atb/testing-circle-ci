<?php

namespace App\Services\ShipStation\Json;

use LaravelDoctrine\ORM\Facades\EntityManager;

class JsonBuildHelper
{

    public function getOrder($orderId)
    {
        $order = EntityManager::getRepository('App\Models\Order\Entities\Order')
                               ->findOneBy(array('id' => $orderId));
        if (empty($order)) {
            return false;
        }
        return $order;
    }

    public function getOrderItems($orderId)
    {
        $orderItems = EntityManager::getRepository('App\Models\Order\Entities\OrderItem')
                               ->findBy(array('order_id' => $orderId, 'product_type' => 'simple'));

        foreach ($orderItems as $orderItem) {
            $options = null;
            $productOptions = $orderItem->getProductOptions();
            if ($productOptions) {
                $x = 0;
                foreach ($productOptions as $productOption) {
                    $options[$x]['name'] = $productOption['label'];
                    $options[$x]['value'] = $productOption['value'];
                    $x++;
                }
            }

            $totalItemPrice = $orderItem->getItemTotalAmount()  - $orderItem->getItemDiscountAmount();
            $unitPrice = $totalItemPrice / $orderItem->getQuantity();

            $items[] = array('sku' => $orderItem->getSku(),
                             'name'  => $orderItem->getName(),
                             'quantity' => $orderItem->getQuantity(),
                             'unitPrice' => $unitPrice,
                             'options' => $options
            );

        }

        if (empty($items)) {
            return false;
        }

        return $items;
    }

    public function getAddress($addressId)
    {
        $address = EntityManager::getRepository('App\Models\Address\Entities\Address')
                                ->findOneBy(array('id' => $addressId));

        if (empty($address)) {
            return false;
        }

        $addressData = array('name' => $address->getFirstName().' '.$address->getLastName(),
                             'company' => $address->getCompany(),
                             'street1'  => $address->getAddress1(),
                             'street2' => $address->getAddress2(),
                             'city' => $address->getCity(),
                             'state' => $address->getState(),
                             'postalCode' => $address->getZipCode(),
                             'country' => $address->getCountry(),
                             'phone' => $address->getPhone()
                            );
        return $addressData;
    }

    public function getOrderStatus($orderStatus)
    {
        switch($orderStatus){
            case 'pending':
            case 'pending_payment':
                $status = 'awaiting_payment';
                break;
            case 'payment_received':
            case 'processing':
            case 'Ordered':
            case 'order_exported':
                $status = 'awaiting_shipment';
                break;
            case 'shipped':
            case 'fedex_exported':
            case 'fedex_int_exported':
            case 'dhl':
            case 'complete':
            case 'purolator_e_exported':
            case 'purolator_w_exported':
                $status = 'shipped';
                break;
            case 'cancelled':
            case 'canceled':
            case 'closed':
            case 'refunded':
            case 'paypal_canceled_reversal':
            case 'paypal_reversed':
                $status = 'cancelled';
                break;
            default:
                $status = 'on_hold';
        }

        return $status;
    }

}
