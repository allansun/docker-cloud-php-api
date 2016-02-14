<?php


namespace DockerCloud\Test\Model;


use Camel\CaseTransformer;
use Camel\Format\SnakeCase;
use Camel\Format\StudlyCaps;
use DockerCloud\Model\AbstractModel;
use DockerCloud\Test\Utility\ClassFinder;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Reflection\StaticReflectionParser;

abstract class AbstractModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string Model Class to be tested
     */
    protected $modelClass;

    static public function setUpBeforeClass()
    {
        $srcPath = realpath(__DIR__ . '/../../src');
        AnnotationRegistry::registerAutoloadNamespace('DockerCloud\Model', $srcPath . DIRECTORY_SEPARATOR . 'Model');

        AnnotationRegistry::registerLoader(function ($class) use ($srcPath) {
            $file = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";

            if (file_exists($srcPath . $file)) {
                // file exists makes sure that the loader fails silently
                require $srcPath . $file;
            }
        });
    }

    public function testGetterSetter()
    {
        $Transformer = new CaseTransformer(new SnakeCase(), new StudlyCaps());
        $data        = $this->getMockData();

        /** @var AbstractModel $Model */
        $Model = new $this->modelClass;
        $Model->exchangeArray(json_decode($data));

        $ModelReflection        = new \ReflectionClass($this->modelClass);
        $ClassFinder            = new ClassFinder('DockerCloud');
        $StaticReflectionParser = new StaticReflectionParser($this->modelClass, $ClassFinder);
        $useStatements          = $StaticReflectionParser->getUseStatements();

        foreach ($ModelReflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $ReflectionProperty) {
            // Parse @var tag
            $DockBlock = new \phpDocumentor\Reflection\DocBlock($ReflectionProperty->getDocComment());
            $this->assertTrue($DockBlock->hasTag('var'));
            $VarTag   = $DockBlock->getTagsByName('var')[0];
            $varTypes = explode('|', str_replace(' ', '', substr($VarTag, 5)));
            //echo $VarTag . PHP_EOL;

            // Get value by using getter method
            $getterMethodName = $Transformer->transform($ReflectionProperty->getName());
            if ('bool' == $VarTag->getContent() || 'boolean' == $VarTag->getContent()) {
                $getterMethodName = 'is' . $getterMethodName;
            } else {
                $getterMethodName = 'get' . $getterMethodName;
            }

            $value = $Model->$getterMethodName();
            if (strpos($VarTag->getContent(), '[]') && is_array($value)) {
                $value = array_pop($value);
            }

            // If there's no actual value we cannot really validate it...
            if (null === $value) {
                continue;
            }

            // Validate value against @var type
            $foundMatchVarType = false;
            foreach ($varTypes as $varType) {
                $varType           = str_replace('[]', '', $varType);
                $foundMatchVarType = $this->validateInternalType($varType, $value);
                if (null !== $foundMatchVarType) {
                    break;
                }
                $foundMatchVarType = $this->validateImportedType($varType, $value, $useStatements);
                if (null !== $foundMatchVarType) {
                    break;
                }
            }
            $this->assertTrue($foundMatchVarType,
                sprintf('[%s] value [%s] is expected type of [%s]',
                    $ReflectionProperty->getName(),
                    print_r($value, true),
                    $VarTag->getContent()
                )
            );
        }
    }

    /**
     * @param $varType
     * @param $value
     *
     * @return bool|null
     * @link http://php.net/manual/en/reserved.other-reserved-words.php
     */
    private function validateInternalType($varType, $value)
    {
        $varType = strtolower($varType);
        switch ($varType) {
            case 'mixed':
                return true;
            case '\stdclass':
                return is_object($value);
            case 'string':
                return is_string($value);
            case 'int':
                return is_int($value);
            case 'bool':
                return is_bool($value);
            case 'float':
                return is_float($value);
            case 'resource':
                return is_resource($value);
            case 'null':
                return is_null($value);
            case 'object':
                return is_object($value);
            case 'numeric':
                return is_numeric($value);
            case 'true':
                return true == $value;
            case 'false':
                return false == $value;
        }

        return null;
    }

    /**
     * @param $varType
     * @param $value
     * @param $useStatements
     *
     * @return bool|null
     */
    private function validateImportedType($varType, $value, $useStatements)
    {
        $varType = strtolower($varType);
        if (array_key_exists($varType, $useStatements)) {
            return $value instanceof $useStatements[$varType];
        }

        return null;
    }

    /**
     * @return \StdClass
     */
    abstract protected function getMockData();
}
