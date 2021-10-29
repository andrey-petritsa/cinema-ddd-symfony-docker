<?php

namespace App\Tests\Functional;

trait ObjectPropertyTrait
{
    protected function getProperties($object): array
    {
        $properties = [];
        foreach ($object as $key => $value) {
            $properties[] = $key;
        }

        return $properties;
    }

    protected function setBlankPropertiesTo(&$object)
    {
        foreach ($object as $key => $value) {
            $object->$key = '';
        }
    }
}
