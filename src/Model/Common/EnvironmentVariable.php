<?php


namespace DockerCloud\Model\Common;

use DockerCloud\Model\AbstractModel;

class EnvironmentVariable extends AbstractModel
{
    /**
     * The name of the environment variable
     *
     * @var string
     */
    protected $key;

    /**
     * The name of the environment variable
     *
     * @var string|mixed
     */
    protected $value;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return static
     */
    static public function build($key, $value)
    {
        $EnvironmentVariable = new static();
        $EnvironmentVariable->setKey($key);
        $EnvironmentVariable->setValue($value);

        return $EnvironmentVariable;
    }
}