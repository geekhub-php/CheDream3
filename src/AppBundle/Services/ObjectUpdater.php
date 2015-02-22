<?php

namespace AppBundle\Services;


class ObjectUpdater
{
    public function updateObject($objectOld, $objectNew)
    {
        if (get_class($objectOld) != get_class($objectNew)) {
            throw new \Exception('class not equals');
        }

        $accessor = new PropertyAccessor();

        $reflect = new \ReflectionClass($objectOld);
        $properties = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE);

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            $newValue = $accessor->getValue($objectNew, $propertyName);

            if ($newValue !== null) {
                $accessor->setValue($objectOld, $propertyName, $newValue);
            }
        }

        return $objectOld;
    }
}
