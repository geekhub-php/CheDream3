<?php

namespace AppBundle\Services;

use AppBundle\Document\Dream;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ObjectUpdater
{
    public function updateObject($objectOld, $objectNew)
    {
        if (get_class($objectOld) != get_class($objectNew)) {
            throw new \Exception();
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $reflect = new \ReflectionClass($objectOld);
        $properties = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);

        foreach ($properties as $property) {

        }
    }
}