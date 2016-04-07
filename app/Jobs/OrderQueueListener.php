<?php

namespace App\Jobs;

use App\Models\Order\Entities\MagentoOrder;
use App\Models\Order\Entities\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderQueueListener extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $connection = 'aws_sqs_shipment';

    protected $_orderEntity;
    protected $_magentoOrderLog;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct(Order $orderEntity, MagentoOrder $mageOrder){
        $this->_orderEntity = $orderEntity;
        $this->_magentoOrderLog = $mageOrder;
    }

    /**
     * Listens to SQS queue and creates order from data
     *
     * @return void
     */

    public function fire(\Illuminate\Contracts\Queue\Job $job, $data){
        $this->setJob($job);
        try{
            $order = $this->_orderEntity->getRepository()->findOneBy(
                    ['order_number' => $data['order']['increment_id']]
            );
            if ($order != null){
                $this->_orderEntity = $order;
                $this->_updateOrder($data);
            } else{
                $this->_createOrder($data);
            }

            /*save to log table for reference*/
            $this->_magentoOrderLog
                    ->setOmsCreatedId($this->_orderEntity->getId())
                    ->setRawJson($data);
            $this->_magentoOrderLog->save();

            $this->delete();
            $orderId = $data['order']['increment_id'];
            Log::info("Processed order number: $orderId from Order SQS Successfully.");
        } catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }

    protected function addShipmentToOrder($magentoRawOrderData){
        $shipment = new \App\Models\Shipment\Entities\Shipment(app('em'));

        $this->_orderEntity
                ->setShipment($shipment->fillFromArray([
                        'shipment_tracking'  => null,
                        'shipstation_synced' => 0,
                ]));
    }

    protected function addOrderItemsToOrder($magentoRawOrderData){
        $orderItemsToAdd = [];
        foreach ($magentoRawOrderData['order_items'] as $magentoOrderItemData){

            $unitPrice = $magentoOrderItemData['price'];
            $totalItemAmount = $magentoOrderItemData['row_total'];
            $discountAmount = $magentoOrderItemData['discount_amount'];

            if($magentoOrderItemData['product_type'] == 'simple' && !is_null($magentoOrderItemData['relative_price'])){
                $unitPrice = $magentoOrderItemData['relative_price'];
                $totalItemAmount = $magentoOrderItemData['relative_price'] * $magentoOrderItemData['qty_ordered'];
                $discountAmount = $magentoOrderItemData['relative_discount_amount'];
            }

            $orderItemsToAdd[] = [
                    'item_id'              => $magentoOrderItemData['item_id'],
                    'parent_item_id'       => $magentoOrderItemData['parent_item_id'],
                    'sku'                  => $magentoOrderItemData['sku'],
                    'name'                 => $magentoOrderItemData['name'],
                    'item_status'          => $magentoRawOrderData['order']['status'],
                    'product_type'         => $magentoOrderItemData['product_type'],
                    'quantity'             => $magentoOrderItemData['qty_ordered'],
                    'price'                => $unitPrice,
                    'item_total_amount'    => $totalItemAmount,
                    'item_tax_amount'      => $magentoOrderItemData['tax_amount'],
                    'item_discount_amount' => $discountAmount,
                    'product_options'      => json_encode($magentoOrderItemData['selected_product_options']),
                    'product_image_url'    => $magentoOrderItemData['product_image_url']
            ];

        }
        $this->_orderEntity
             ->setOrderItems($orderItemsToAdd);
    }

    protected function addAddressesToOrder($magentoRawOrderData){

        $billingAddress = new \App\Models\Address\Entities\Address(app('em'));
        $shippingAddress = new \App\Models\Address\Entities\Address(app('em'));

        $billingAddressRaw = $magentoRawOrderData['billing_address'];
        $shippingAddressRaw = $magentoRawOrderData['shipping_address'];
        $billingAddress->fillFromArray([
                'firstname' => $billingAddressRaw['firstname'],
                'lastname'  => $billingAddressRaw['lastname'],
                'phone'     => $billingAddressRaw['telephone'],
                'address_1' => $billingAddressRaw['street'],
                'address_2' => '',
                'city'      => $billingAddressRaw['city'],
                'state'     => $billingAddressRaw['region'],
                'country'   => $billingAddressRaw['country_id'],
                'zipcode'   => $billingAddressRaw['postcode'],
                'company'   => $billingAddressRaw['company'],
        ]);
        $shippingAddress->fillFromArray([
                'firstname' => $shippingAddressRaw['firstname'],
                'lastname'  => $shippingAddressRaw['lastname'],
                'phone'     => $shippingAddressRaw['telephone'],
                'address_1' => $shippingAddressRaw['street'],
                'address_2' => '',
                'city'      => $shippingAddressRaw['city'],
                'state'     => $shippingAddressRaw['region'],
                'country'   => $shippingAddressRaw['country_id'],
                'zipcode'   => $shippingAddressRaw['postcode'],
                'company'   => $shippingAddressRaw['company'],
        ]);

        $this->_orderEntity->setBillingAddress($billingAddress);
        $this->_orderEntity->setShippingAddress($shippingAddress);
    }

    protected function _createOrder($data){
        $this->_orderEntity->setOrderNumber($data['order']['increment_id'])
                ->setOrderDate($data['order']['created_at'])
                ->setStatus($data['order']['status'])
                ->setCouponCode($data['order']['coupon_code'])
                ->setVolume($data['order']['order_calculated_volume'])
                ->setPaymentMethod($data['order_payment']['method'])
                ->setShippingMethod($data['order']['shipping_description'])
                ->setTaxAmount($data['order']['tax_amount'])
                ->setShippingAmount($data['order']['shipping_amount'])
                ->setDiscountAmount($data['order']['discount_amount'])
                ->setGrandTotal($data['order']['grand_total'])
                ->setEmail($data['shipping_address']['email']);

        $this->addShipmentToOrder($data);
        $this->addAddressesToOrder($data);
        $this->addOrderItemsToOrder($data);
        $this->_orderEntity->save();
        return;
    }

    protected function _updateOrder($data){
        $this->_orderEntity->setOrderNumber($data['order']['increment_id'])
                ->setStatus($data['order']['status']);

        $shipment = $this->_orderEntity
                ->getShipment();

        $shipment->fillFromArray([
                'shipstation_synced' => 0,
        ]);

        $shippingAddressRaw = $data['shipping_address'];
        $billingAddressRaw = $data['billing_address'];

        $shippingAddress = $this->_orderEntity->getShippingAddress();
        $shippingAddress->fillFromArray(
                [
                        'firstname' => $shippingAddressRaw['firstname'],
                        'lastname'  => $shippingAddressRaw['lastname'],
                        'phone'     => $shippingAddressRaw['telephone'],
                        'address_1' => $shippingAddressRaw['street'],
                        'address_2' => '',
                        'city'      => $shippingAddressRaw['city'],
                        'state'     => $shippingAddressRaw['region'],
                        'country'   => $shippingAddressRaw['country_id'],
                        'zipcode'   => $shippingAddressRaw['postcode'],
                        'company'   => $shippingAddressRaw['company'],
                ]
        );

        $billingAddress = $this->_orderEntity->getBillingAddress();
        $billingAddress->fillFromArray(
                [
                        'firstname' => $billingAddressRaw['firstname'],
                        'lastname'  => $billingAddressRaw['lastname'],
                        'phone'     => $billingAddressRaw['telephone'],
                        'address_1' => $billingAddressRaw['street'],
                        'address_2' => '',
                        'city'      => $billingAddressRaw['city'],
                        'state'     => $billingAddressRaw['region'],
                        'country'   => $billingAddressRaw['country_id'],
                        'zipcode'   => $billingAddressRaw['postcode'],
                        'company'   => $billingAddressRaw['company'],
                ]
        );
        return;
    }
}
