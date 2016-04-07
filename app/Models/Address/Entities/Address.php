<?php

namespace App\Models\Address\Entities;

use App\Contracts\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="`address`")
 * @ORM\Entity(repositoryClass="App\Models\Address\Repositories\AddressRepository")
 */
class Address extends DoctrineModel
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $id;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $firstname;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $lastname;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $phone;

    /**
    * @ORM\Column(type="string", length=255, nullable=false)
    */
    protected $address_1;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    protected $address_2;

    /**
    * @ORM\Column(type="string", length=98, nullable=false)
    */
    protected $city;

    /**
    * @ORM\Column(type="string", length=98, nullable=true)
    */
    protected $state;

    /**
    * @ORM\Column(type="string", length=2, nullable=false)
    */
    protected $country;

    /**
    * @ORM\Column(type="string", length=10, nullable=false)
    */
    protected $zipcode;

    /**
    * @ORM\Column(type="string", length=98, nullable=true)
    */
    protected $company;

    /**
    * @ORM\Column(type="string", length=25, nullable=false)
    */
    protected $type;

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
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $first_name
     * @return Address
     */
    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $status
     * @return Order
     */
    public function setLastName($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param mixed $address_1
     * @return Address
     */
    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address_2;
    }

    /**
     * @param mixed $address_1
     * @return Address
     */
    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     * @return Address
     */
    public function setZipCode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     * @return Address
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Address
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return \App\Models\Orders\Repositories\OrderRepository
     */
    public function getRepository()
    {
        return parent::getRepository();
    }
}
