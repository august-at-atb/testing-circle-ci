<?php

namespace App\Contracts;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use LaravelDoctrine\ORM\Pagination\Paginatable;
use LaravelDoctrine\ORM\Pagination\PaginatorAdapter;

abstract class DoctrineRepository extends EntityRepository {
    use Paginatable;

    protected $_defaultAlias = 'tbl';

    protected $_defaultSortBy = 'id';
    protected $_defaultSortOrder = 'DESC';


    /**
     * @param Query  $query
     * @param int    $perPage
     * @param bool   $fetchJoinCollection
     * @param string $pageName
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(Query $query, $perPage, $pageName = 'page', $fetchJoinCollection = false)
    {
        return (new PaginatorAdapter())->make(
            $query,
            $perPage,
            $pageName,
            $fetchJoinCollection
        );
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @return \App\Contracts\DoctrineModel
     *
     * @throws EntityNotFoundException
     */

    public function findOrFail($id){
        $result = $this->find($id);

        if (is_array($id)){
            if (count($result) == count(array_unique($id))){
                return $result;
            }
        } elseif (!is_null($result)){
            return $result;
        }

        throw new EntityNotFoundException();
    }

    /**
     * Get filtered, ordered and paginated collection
     *
     * @param  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    public function applyFilter(RepositoryFilterContract $repoFilter){
        $filterParams = $repoFilter->getFilterBy();
        $order = $repoFilter->getOrderBy();
        $perPage = $repoFilter->getPerPage();

        $qb = $this->_em->createQueryBuilder();

        $qb->select($this->_defaultAlias)
                ->from($this->getEntityName(), $this->_defaultAlias)
                ->orderBy($this->_defaultAlias . '.' . $this->_defaultSortBy, $this->_defaultSortOrder);

        foreach ($filterParams as $fieldName => $filterValue){
            if ($filterValue){
                $qb->andWhere($qb->expr()->like($this->_defaultAlias . '.' . $fieldName, $qb->expr()->literal('%' . $filterValue . '%')));
            }
        }
        if ($order){
            $qb->orderBy($this->_defaultAlias . '.' . $order['orderBy'], $order['orderDirection']);
        }

        return $this->paginate($qb->getQuery(), $perPage);
    }
}
