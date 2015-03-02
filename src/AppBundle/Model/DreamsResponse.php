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
     * @var string
     * @Type("string")
     * @Expose
     */
    protected $sortOrder;

    /**
     * @var string
     * @Type("string")
     * @Expose
     */
    protected $nextPage;

    /**
     * @var string
     * @Type("string")
     * @Expose
     */
    protected $previousPage;

    /**
     * @var integer
     * @Type("integer")
     * @Expose
     */
    protected $pageCount;

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

    /**
     * @param mixed $nextPage
     */
    public function setNextPage($nextPage)
    {
        $this->nextPage = $nextPage;
    }

    /**
     * @return mixed
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }

    /**
     * @param mixed $previousPage
     */
    public function setPreviousPage($previousPage)
    {
        $this->previousPage = $previousPage;
    }

    /**
     * @return mixed
     */
    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    /**
     * @param mixed $pageCount
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;
    }

    /**
     * @return mixed
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }
}