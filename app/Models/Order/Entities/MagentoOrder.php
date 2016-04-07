<?php

namespace App\Models\Order\Entities;

use App\Contracts\DoctrineModel;
use Doctrine\ORM\Mapping AS ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="magento_order_data_log")
 */
class MagentoOrder extends DoctrineModel {
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */

    protected $id;

    /**
     * @ORM\Column(type="json")
     */

    protected $raw_json;

    /**
     * @ORM\Column(type="integer")
     */

    protected $oms_created_id;

    protected function _init()
    {
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return MagentoOrder
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawJson(){
        return $this->raw_json;
    }

    /**
     * @param mixed $raw_json
     * @return MagentoOrder
     */
    public function setRawJson($raw_json){
        $this->raw_json = $raw_json;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOmsCreatedId(){
        return $this->oms_created_id;
    }

    /**
     * @param mixed $oms_created_id
     * @return MagentoOrder
     */
    public function setOmsCreatedId($oms_created_id){
        $this->oms_created_id = $oms_created_id;
        return $this;
    }

}
