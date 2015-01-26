<?php
namespace AppBundle\Document;

trait ContactInfo
{

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $phone;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $skype;
}
