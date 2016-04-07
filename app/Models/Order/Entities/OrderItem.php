<?php

namespace App\Models\Order\Entities;

use App\Contracts\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_item")
 * @ORM\Entity(repositoryClass="App\Models\Order\Repositories\OrderItemRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OrderItem extends DoctrineModel
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $id;

    /**
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $order_id;

    /**
     * @ORM\Column(type="string", length=98, nullable=true)
     */

    protected $item_id;

    /**
     * @ORM\Column(type="string", length=98, nullable=true)
     */

    protected $parent_item_id;

    /**
    * @ORM\Column(type="string", length=98, nullable=true)
    */
    protected $sku;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $name;

    /**
     * @ORM\Column(type="string", length=98, nullable=true)
     */

    protected $product_type = null;

    /**
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $quantity;

    /**
    * @ORM\Column(type="decimal", precision=12, scale=4)
    */
    protected $price;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */
    protected $item_total_amount = 0.0000;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */
    protected $item_tax_amount = 0.0000;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */
    protected $item_discount_amount = 0.0000;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $product_image_url = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $product_options = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Models\Order\Entities\Order", inversedBy="order_items")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @return \App\Models\Order\Repositories\OrderItemRepository
     */
    public function getRepository()
    {
        return parent::getRepository();
    }

    protected function _init()
    {
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
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $order_number
     * @return Order
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentItemId()
    {
        return $this->parent_item_id;
    }

    /**
     * @param mixed $order_number
     * @return Order
     */
    public function setParentItemId($parent_item_id)
    {
        $this->parent_item_id = $parent_item_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     * @return Order
     */
    public function setOrderNumber($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     * @return OrderItem
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $sku
     * @return OrderItem
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return OrderItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return OrderItem
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->item_tax_amount;
    }

    /**
     * @param mixed $item_tax_amount
     * @return OrderItem
     */
    public function setTaxAmount($item_tax_amount)
    {
        $this->item_tax_amount = $item_tax_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductType(){
        return $this->product_type;
    }

    /**
     * @param mixed $product_type
     * @return OrderItem
     */
    public function setProductType($product_type){
        $this->product_type = $product_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemTotalAmount(){
        return $this->item_total_amount;
    }

    /**
     * @param mixed $item_total_amount
     * @return OrderItem
     */
    public function setItemTotalAmount($item_total_amount){
        $this->item_total_amount = $item_total_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemTaxAmount(){
        return $this->item_tax_amount;
    }

    /**
     * @param mixed $item_tax_amount
     * @return OrderItem
     */
    public function setItemTaxAmount($item_tax_amount){
        $this->item_tax_amount = $item_tax_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemDiscountAmount(){
        return $this->item_discount_amount;
    }

    /**
     * @param mixed $item_discount_amount
     * @return OrderItem
     */
    public function setItemDiscountAmount($item_discount_amount){
        $this->item_discount_amount = $item_discount_amount;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getProductImageUrl(){
        return $this->product_image_url;
    }

    /**
     * @param mixed $product_image_url
     * @return OrderItem
     */
    public function setProductImageUrl($product_image_url){
        $this->product_image_url = $product_image_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductOptions(){
        return json_decode($this->product_options, true);
    }

    /**
     * @param mixed $product_options
     * @return OrderItem
     */
    public function setProductOptions(array $product_options){
        $this->product_options = json_encode($product_options);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     * @return OrderItem
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

}
