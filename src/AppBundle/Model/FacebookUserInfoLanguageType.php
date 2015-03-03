<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation\Type;

class FacebookUserInfoLanguageType
{
    /**
     * @Type("integer")
     */
    protected $id;

    /**
     * @Type("string")
     */
    protected $name;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
