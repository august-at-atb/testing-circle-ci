<?php

namespace App\Log;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
/**
 * @ORM\Entity
 * @ORM\Table(name="api_log")
 */
class ApiLogEntry
{
    use Timestamps;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */

    protected $_em;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $action = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $transaction_token = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $result_code = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $username = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $comment = null;

    /**
     * @return EntityManagerInterface
     *
     */

    public function getEntityManager()
    {
        return ($this->_em) ? $this->_em : app('em');
    }

    public function save()
    {
        $this->getEntityManager()->persist($this);
        $this->getEntityManager()->flush();
        return $this;
    }

    public function remove()
    {
        $this->getEntityManager()->remove($this);
        $this->getEntityManager()->flush();
        return;
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
     * @return ApiLogEntry
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return ApiLogEntry
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionToken()
    {
        return $this->transaction_token;
    }

    /**
     * @param mixed $transaction_token
     * @return ApiLogEntry
     */
    public function setTransactionToken($transaction_token)
    {
        $this->transaction_token = $transaction_token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResultCode()
    {
        return $this->result_code;
    }

    /**
     * @param mixed $result_code
     * @return ApiLogEntry
     */
    public function setResultCode($result_code)
    {
        $this->result_code = $result_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return ApiLogEntry
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return ApiLogEntry
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

}
