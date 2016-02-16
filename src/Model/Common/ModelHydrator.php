<?php


namespace DockerCloud\Model\Common;

use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\ExtractionInterface;
use Zend\Hydrator\Filter\FilterComposite;
use Zend\Hydrator\HydrationInterface;
use Zend\Hydrator\ObjectProperty;
use Zend\Hydrator\Reflection;

class ModelHydrator implements HydrationInterface, ExtractionInterface
{
    /**
     * @var ModelHydrator
     */
    static private $instance;

    /**
     * @var ClassMethods
     */
    private $hydrator;

    /**
     * ModelHydrator constructor.
     */
    private function __construct()
    {

    }

    /**
     * @return ModelHydrator
     */
    static public function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new ModelHydrator();
        }

        return static::$instance;
    }

    /**
     * @param $object
     *
     * @return array
     */
    public function extract($object)
    {
        $hydrator = new Reflection();

        return $hydrator->extract($object);
    }

    /**
     * @param array $data
     * @param       $object
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        $hydrator = new ClassMethods();

        return $hydrator->hydrate($data, $object);
    }
}