<?php


namespace DockerCloud;

use Camel\CaseTransformer;
use Camel\Format\SnakeCase;
use Camel\Format\StudlyCaps;

class Utility
{

    /**
     * @var CaseTransformer
     */
    static $Transformer;


    /**
     * @return CaseTransformer
     */
    static public function getTransformer()
    {
        if (!static::$Transformer) {
            static::$Transformer = new CaseTransformer(new SnakeCase(), new StudlyCaps());
        }

        return static::$Transformer;
    }

}