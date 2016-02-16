<?php


namespace DockerCloud\Model;


class ServiceTrigger extends AbstractModel
{
    const OPERATION_REDEPLOY = 'REDEPLOY';
    const OPERATION_SCALEUP = 'SCALEUP';

    /**
     * Address to be used to call the trigger with a POST request
     *
     * @var string
     */
    protected $url;
    /**
     * A user provided name for the trigger
     *
     * @var string
     */
    protected $name;
    /**
     * The operation that the trigger call performs (see const OPERATION_* )
     *
     * @var string
     */
    protected $operation;
    /**
     * A unique API endpoint that represents the trigger
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     *
     * @return $this
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceUri()
    {
        return $this->resource_uri;
    }

    /**
     * @param string $resource_uri
     *
     * @return $this
     */
    public function setResourceUri($resource_uri)
    {
        $this->resource_uri = $resource_uri;

        return $this;
    }

    public function getArrayCopy($fieldsToInclude = [])
    {
        return parent::getArrayCopy(array_merge($fieldsToInclude, [
            'image',
            'operation',
        ]));
    }

}