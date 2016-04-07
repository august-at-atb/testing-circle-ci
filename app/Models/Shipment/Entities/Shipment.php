<?php

namespace App\Models\Shipment\Entities;

use App\Contracts\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="`shipment`")
 * @ORM\Entity(repositoryClass="App\Models\Shipment\Repositories\ShipmentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Shipment extends DoctrineModel
{
    use Timestamps;

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
     * @ORM\Column(type="string", length=25, nullable=true)
     */

    protected $ship_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $shipment_tracking = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $carrier_code = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $service_code = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $package_code = null;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */

    protected $shipstation_synced = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */

    protected $sync_try = 0;

    protected $hidden = ['order'];

    /**
     * @ORM\OnetoOne(targetEntity="App\Models\Order\Entities\Order", inversedBy="shipment")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */

    protected $order;

    protected function _init()
    {
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
     * @param mixed $id
     * @return Shipment
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     * @return Shipment
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
    * @return mixed
    */
    public function getShipDate()
    {
        return $this->ship_date;
    }

    /**
    * @param mixed $ship_date
    * @return Shipment
    */
    public function setShipDate($ship_date)
    {
        $this->ship_date = $ship_date;
        return $this;
    }

    /**
    * @return mixed
    */
    public function getShipmentTracking()
    {
        return $this->shipment_tracking;
    }

    /**
    * @param mixed $shipment_tracking
    * @return Shipment
    */
    public function setShipmentTracking($shipment_tracking)
    {
        $this->shipment_tracking = $shipment_tracking;
        return $this;
    }

    /**
    * @return mixed
    */
    public function getCarrierCode()
    {
        return $this->carrier_code;
    }

    /**
    * @param mixed $carrier_code
    * @return Shipment
    */
    public function setCarrierCode($carrier_code)
    {
        $this->carrier_code = $carrier_code;
        return $this;
    }

    /**
    * @return mixed
    */
    public function getServiceCode()
    {
        return $this->service_code;
    }

    /**
    * @param mixed $service_code
    * @return Shipment
    */
    public function setServiceCode($service_code)
    {
        $this->service_code = $service_code;
        return $this;
    }

    /**
    * @return mixed
    */
    public function getPackageCode()
    {
        return $this->package_code;
    }

    /**
    * @param mixed $package_code
    * @return Shipment
    */
    public function setPackageCode($package_code)
    {
        $this->package_code = $package_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShipStationSynced()
    {
        return $this->shipstation_synced;
    }

    /**
     * @param mixed $shipstation_synced
     * @return Shipment
     */
    public function setShipStationSynced($shipstation_synced)
    {
        $this->shipstation_synced = $shipstation_synced;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSyncTry()
    {
        return $this->sync_try;
    }

    /**
     * @param mixed $sync_try
     * @return Shipment
     */
    public function setSyncTry($sync_try)
    {
        $this->sync_try = $sync_try;
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
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
}
