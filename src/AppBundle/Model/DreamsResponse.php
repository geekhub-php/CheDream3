<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Class DreamResponse
 * @package AppBundle\Model
 * @ExclusionPolicy("all")
 */
class DreamsResponse
{

     /**
     * @var Array[]
     * @Type("array<AppBundle\Document\Dream>")
     * @Expose
     */
    protected $dreams;

    /**
     * @var integer
     * @Type("integer")
     * @Expose
     */
    protected $limit;

    /**
     * @var integer
     * @Type("integer")
     * @Expose
     */
    protected $page;

    /**
     * @var string
     * @Type("string")
     * @Expose
     */
    protected $sortBy;

    /**
     * @var string
     * @Type("string")
     * @Expose
     */
    protected $sortOrder;

    /**
     * @param mixed $dreams
     */
    public function setDreams($dreams)
    {
        $this->dreams = $dreams;
    }

    /**
     * @return mixed
     */
    public function getDreams()
    {
        return $this->dreams;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $sortBy
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param mixed $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

}