<?php


namespace DockerCloud\Model\Common;

use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\ExtractionInterface;
use Zend\Hydrator\Filter\FilterComposite;
use Zend\Hydrator\HydrationInterface;

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
        $this->hydrator = new ClassMethods();
        $this->hydrator->addFilter("arrayCopy",
            function ($property) {
                list($class, $method) = explode('::', $property);
                if ($method === 'getArrayCopy') {
                    return false;
                }
                unset($class);

                return true;
            }, FilterComposite::CONDITION_AND
        );
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
        return $this->hydrator->extract($object);
    }

    /**
     * @param array $data
     * @param       $object
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        return $this->hydrator->hydrate($data, $object);
    }
}