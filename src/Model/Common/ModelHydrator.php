<?php


namespace DockerCloud\Model\Common;

use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\ExtractionInterface;
use Zend\Hydrator\Filter\FilterComposite;
use Zend\Hydrator\HydrationInterface;
use Zend\Hydrator\Reflection;

class ModelHydrator implements HydrationInterface, ExtractionInterface
{
    /**
     * @var ModelHydrator
     */
    static private $instance;

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
     * @param object $object
     *
     * @param array  $fieldsTobeFiltered
     *
     * @return array
     */
    public function extract($object, $fieldsToInclude = [])
    {
        $hydrator = new Reflection();
        $hydrator->addFilter('exclude',
            function ($property) use ($fieldsToInclude) {
                if (0 == count($fieldsToInclude)) {
                    return true;
                }

                if (!in_array($property, $fieldsToInclude)) {
                    return false;
                }

                return true;
            }, FilterComposite::CONDITION_AND
        );

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