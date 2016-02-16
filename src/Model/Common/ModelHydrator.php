<?php


namespace DockerCloud\Model\Common;

use DockerCloud\Model\AbstractModel;
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
        if(!is_object($object)){
            return $object;
        }

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

        $resultCopy = $result = $hydrator->extract($object);
        array_walk($resultCopy, function (&$value,$key) use(&$result)  {
            if($value instanceof AbstractModel){
                $value = $value->getArrayCopy();
            }
            if (is_null($value)) {
                unset($result[$key]);
            }
            if(is_array($value)){
                array_walk($value, function(&$value){
                    $value = $this->extract($value);
                });
            }
        });
        return $result;
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