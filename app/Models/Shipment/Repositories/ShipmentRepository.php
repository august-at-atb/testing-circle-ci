<?php

namespace App\Models\Shipment\Repositories;

use App\Models\Shipment\Entities\Shipment as Shipment;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use App\Contracts\DoctrineRepository;

class ShipmentRepository extends DoctrineRepository
{
    public function getNextShipments($limit = 30)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select($this->_defaultAlias . '.' . 'order_id')
            ->from($this->getEntityName(), $this->_defaultAlias)
            ->where($this->_defaultAlias. '.' .'shipstation_synced = :shipstation_synced')
            ->orderBy($this->_defaultAlias . '.' . 'id', 'DESC')
            ->setParameter('shipstation_synced', 0)
            ->setMaxResults($limit);

        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }

    public function getFailedShipments($limit = 10)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select($this->_defaultAlias . '.' . 'order_id')
            ->from($this->getEntityName(), $this->_defaultAlias)
            ->where($this->_defaultAlias. '.' .'shipstation_synced != :shipstation_synced')
            ->andWhere($this->_defaultAlias. '.' .'shipstation_synced != :shipstation_unsynced')
            ->andWhere($this->_defaultAlias. '.' .'sync_try < 10')
            ->orderBy($this->_defaultAlias . '.' . 'id', 'ASC')
            ->setParameter('shipstation_synced', 1)
            ->setParameter('shipstation_unsynced', 0)
            ->setMaxResults($limit);

        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }
}
