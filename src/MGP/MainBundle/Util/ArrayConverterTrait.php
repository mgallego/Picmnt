<?php

namespace MGP\MainBundle\Util;

use Doctrine\Common\Util\ClassUtils;

trait ArrayConverterTrait
{

    /**
     * fromArray
     *
     * @param array $dataArray Data array
     */
    public function fromArray(array $dataArray)
    {
        foreach ($dataArray as $key => $value) {
            $methodName = "set" . ucfirst($key);
            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            }
        }

        return $this;
    }

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

        if ($isObj && in_array('Doctrine\Common\Collections\Collection', class_implements($var))) {
            $var = $var->toArray();
        }

        if ($maxDepth) {
            if (is_array($var)) {
                $return = array();

                foreach ($var as $k => $v) {
                    $return[$k] = self::export($v, $maxDepth - 1);
                }
            } elseif ($isObj) {
                $return = [];
                if ($var instanceof \DateTime) {
                    $return = $var;
                } else {
                    $reflClass = ClassUtils::newReflectionObject($var);

                    foreach ($reflClass->getProperties() as $reflProperty) {
                        $name = $reflProperty->getName();

                        $reflProperty->setAccessible(true);
                        $return[$name] = self::export($reflProperty->getValue($var), $maxDepth - 1);
                    }
                }
            } else {
                $return = $var;
            }
        } else {
            $return = is_object($var) ? get_class($var)
                : (is_array($var) ? 'Array(' . count($var) . ')' : $var);
        }

        return $return;
    }
}
