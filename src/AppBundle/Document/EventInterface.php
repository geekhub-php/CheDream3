<?php
namespace AppBundle\Document;

interface EventInterface
{
    public function getCreatedAt();

    public function getEventImage();

    public function getEventTitle();
}
