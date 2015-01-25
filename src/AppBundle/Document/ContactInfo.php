<?php
namespace AppBundle\Document;

trait ContactsInfo
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
