<?php

namespace MGP\MainBundle\Util;

use Doctrine\Common\Util\ClassUtils;

trait ArrayConverterTrait
{

    /**
     * toArray
     *
     * @return array
     */
    public function toArray($maxDepth = 5)
    {
        return self::export($this, $maxDepth++);
    }

    /**
     * Modified copy of Doctrine\Common\Util\Debug
     *
     * Every object is transformed into an array unless DateTime objects
     *
     * @param mixed $var
     * @param int $maxDepth
     * @return mixed
     */
    public static function export($var, $maxDepth)
    {

        $return = null;
        $isObj = is_object($var);

        if ($maxDepth && $isObj && !($var instanceof \DateTime) && !is_array($var)) {
            $return = [];
            $reflClass = ClassUtils::newReflectionObject($var);
            
            foreach ($reflClass->getProperties() as $reflProperty) {
                $name = $reflProperty->getName();
                
                    $reflProperty->setAccessible(true);
                    $return[$name] = self::export($reflProperty->getValue($var), $maxDepth - 1);
            }
            
            return $return;
        }
        return $var;
    }
}
