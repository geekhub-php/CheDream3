<?php

namespace Geekhub\UserBundle\Model;

use JMS\Serializer\Annotation\Type;

class OdnoklassnikiPhotoResponse
{
    /**
     * @Type("array")
     */
    protected $photoArray;

    /**
     * @Type("array")
     */
    protected $photos;

    public function getPhoto()
    {
        if (($this->photos)&&(array_key_exists('standard_url', $this->photos[0]))) {
            return $this->photos[0]['standard_url'];
        } else {
            return null;
        }
    }
}
