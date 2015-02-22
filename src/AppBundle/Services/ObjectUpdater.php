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
            $prop = $accessor->getValue($property, 'name');

            $uc_prop = ucfirst($prop);
            $get_prop = 'get'.$uc_prop;
            $set_prop = 'set'.$uc_prop;

            if ($objectNew->$get_prop() !== null) {
                $objectOld->$set_prop($objectNew->$get_prop());
            }
        }

        return $objectOld;
    }
}