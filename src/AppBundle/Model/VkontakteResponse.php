<?php

namespace Geekhub\UserBundle\Model;

use JMS\Serializer\Annotation\Type;

class VkontakteResponse
{
    /**
     * @Type("array")
     */
    protected $response;

    public function getResponse($field)
    {
        if ($this->response &&array_key_exists('0', $this->response) && array_key_exists($field, $this->response[0])) {
             return $this->response[0][$field];
        } else {
            return '';
        }
    }
}
