<?php


namespace DockerCloud\Test\Utility;

use Doctrine\Common\Reflection\ClassFinderInterface;

/**
 * A class finder to be used in AbstractModelTest
 *
 * @link    https://github.com/doctrine/common/blob/master/lib/Doctrine/Common/Reflection/StaticReflectionParser.php
 *
 * @package DockerCloud\Test\Utility
 */
class ClassFinder implements ClassFinderInterface
{
    protected $psr4NameSpace = null;

    public function __construct($psr4NameSpace = null)
    {
        $this->psr4NameSpace = $psr4NameSpace;
    }

    public function findFile($class)
    {
        if ($this->psr4NameSpace) {
            $class = substr($class, strlen($this->psr4NameSpace));
        }

        $srcPath = realpath(__DIR__ . '/../../src');
        $file    = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";

        if (file_exists($srcPath . $file)) {
            // file exists makes sure that the loader fails silently
            return $srcPath . $file;
        }
    }
}