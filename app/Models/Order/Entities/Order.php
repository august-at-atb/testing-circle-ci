<?php

namespace App\Models\Order\Entities;

use App\Contracts\DoctrineModel;
use App\Models\Shipment\Entities\Shipment;
use App\Models\Address\Entities\Address;
use App\Models\Order\Entities\OrderItem;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="`order`")
 * @ORM\Entity(repositoryClass="App\Models\Order\Repositories\OrderRepository")
 */
class Order extends DoctrineModel
{
    use Timestamps;

    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $id;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $order_number;

    /**
    *
    * @ORM\Column(type="string", length=25, nullable=false)
    */
    protected $order_date;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $status;

    /**
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $billing_address_id;

    /**
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $shipping_address_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $email = null;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    protected $coupon_code = null;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $payment_method;

    /**
    * @ORM\Column(type="decimal", precision=12, scale=4)
    */
    protected $shipping_amount;

    /**
    * @ORM\Column(type="decimal", precision=12, scale=4)
    */
    protected $tax_amount;

    /**
    * @ORM\Column(type="decimal", precision=12, scale=4)
    */
    protected $discount_amount;

    /**
    * @ORM\Column(type="decimal", precision=12, scale=4)
    */
    protected $grand_total;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */

    protected $shipping_method = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */

    protected $volume = null;

    /**
     * @ORM\OnetoOne(targetEntity="App\Models\Shipment\Entities\Shipment", mappedBy="order", cascade={"persist", "remove"})
     */

    protected $shipment;

    /**
     * @ORM\OneToOne(targetEntity="App\Models\Address\Entities\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id")
     */

    protected $billing_address;

    /**
     * @ORM\OneToOne(targetEntity="App\Models\Address\Entities\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="shipping_address_id", referencedColumnName="id")
     */

    protected $shipping_address;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Models\Order\Entities\OrderItem", mappedBy="order", cascade={"persist", "remove"}))
     */

    protected $order_items;

    protected function _init()
    {
        $this->order_items = new ArrayCollection();
    }

    /**
     * @return \App\Models\Orders\Repositories\OrderRepository
     */
    public function getRepository()
    {
        return parent::getRepository();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $shipment_id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->order_number;
    }

    /**
     * @param mixed $order_number
     * @return Order
     */
    public function setOrderNumber($order_number)
    {
        $this->order_number = $order_number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->order_date;
    }

    /**
     * @param mixed $order_number
     * @return Order
     */
    public function setOrderDate($order_date)
    {
        $this->order_date = $order_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingAddressId()
    {
        return $this->billing_address_id;
    }

    /**
     * @param mixed $status
     * @return Order
     */
    public function setBillingAddressId($billing_address_id)
    {
        $this->billing_address_id = $billing_address_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingAddressId()
    {
        return $this->shipping_address_id;
    }

    /**
     * @param mixed $status
     * @return Order
     */
    public function setShippingAddressId($shipping_address_id)
    {
        $this->shipping_address_id = $shipping_address_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Order
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCouponCode()
    {
        return $this->coupon_code;
    }

    /**
     * @param mixed $notes
     * @return Order
     */
    public function setCouponCode($coupon_code)
    {
        $this->coupon_code = $coupon_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * @param mixed $payment_method
     * @return Payment
     */
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingAmount()
    {
        return $this->shipping_amount;
    }

    /**
     * @param mixed $shipping_amount
     * @return Payment
     */
    public function setShippingAmount($shipping_amount)
    {
        $this->shipping_amount = $shipping_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->tax_amount;
    }

    /**
     * @param mixed $tax_amount
     * @return Payment
     */
    public function setTaxAmount($tax_amount)
    {
        $this->tax_amount = $tax_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount()
    {
        return $this->discount_amount;
    }

    /**
     * @param mixed $discount_amount
     * @return Payment
     */
    public function setDiscountAmount($discount_amount)
    {
        $this->discount_amount = $discount_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrandTotal()
    {
        return $this->grand_total;
    }

    /**
     * @param mixed $grand_total
     * @return Payment
     */
    public function setGrandTotal($grand_total)
    {
        $this->grand_total = $grand_total;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingMethod()
    {
        return $this->shipping_method;
    }

    /**
     * @param mixed $method_name
     * @return Order
     */
    public function setShippingMethod($shipping_method)
    {
        $this->shipping_method = $shipping_method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     * @return Order
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * @param mixed $shipment
     * @return Order
     */
    public function setShipment(Shipment $shipment)
    {
        $this->shipment = $shipment;
        $this->shipment->setOrder($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billing_address;
    }

    /**
     * @param mixed $billing_address
     * @return Order
     */
    public function setBillingAddress(Address $billing_address)
    {
        $this->billing_address = $billing_address;
        $this->billing_address->setType('billing');
        return $this;
    }

    /**
     * @return Address
     *
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * @param mixed $shipping_address
     * @return Order
     */
    public function setShippingAddress(Address $shipping_address)
    {
        $this->shipping_address = $shipping_address;
        $this->shipping_address->setType('shipping');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderItems()
    {
        return $this->order_items;
    }

    /**
     * @param mixed $order_items
     * @return Order
     */
    public function setOrderItems(array $order_items)
    {
        foreach ($order_items as $orderItemData) {
            $orderItemInstance = new OrderItem(app('em'));
            $orderItemInstance->fillFromArray($orderItemData);
            $orderItemInstance->setOrder($this);
            $this->order_items->add($orderItemInstance);
        }
        return $this;
    }
}
