<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 12.02.16
 *
 */

namespace App\Contracts;

/**
 * Class RepositoryFilterContract
 * @package App\Contracts
 */

abstract class RepositoryFilterContract {

    /**
     * @var array
     */
    protected $_order = [];

    /**
     * @var int
     */
    protected $_perPage = 15;

    /**
     * @var array
     */
    protected $_params = [];

    /**
     * @return mixed
     */
    abstract public function getOrderBy();

    /**
     * @return mixed
     */
    abstract public function getPerPage();

    /**
     * @return mixed
     */
    abstract public function getFilterBy();

    /**
     * @param $orderBy
     * @return $this
     */
    public function setOrderBy($orderBy){
        $this->_order = $orderBy;
        return $this;
    }

    /**
     * @param $perPage
     * @return $this
     */
    public function setPerPage($perPage){
        $this->_perPage = $perPage;
        return $this;
    }

    /**
     * @param $params
     * @return $this
     */
    public function setFilterBy($params){
        $this->_params = $params;
        return $this;
    }

}