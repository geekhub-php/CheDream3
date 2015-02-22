<?php

namespace AppBundle\Services;

use AppBundle\Document\Dream;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ObjectUpdater
{
    public function updateObject($objectOld, $objectNew)
    {
        if (get_class($objectOld) != get_class($objectNew)) {
            throw new \Exception('class not equals');
        }

        $accessor = $propertyAccessor  = new PropertyAccessor();

        $reflect = new \ReflectionClass($objectOld);
        $properties = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE);

        foreach ($properties as $property) {
            $prop = $property->getName();

            $newValue = $accessor->getValue($objectNew, $prop);

            if ($newValue !== null) {
                $accessor->setValue($objectOld, $prop, $newValue);
            }
        }

        return $objectOld;
    }
}