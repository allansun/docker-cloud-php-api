<?php


namespace DockerCloud\Model;


class Repository extends AbstractRepoModel
{
    /**
     * A unique API endpoint that represents the repository
     *
     * @var string
     */
    protected $resource_uri;
    /**
     * Name of the repository, i.e. quay.io/tutum/ubuntu
     *
     * @var string
     */
    protected $name;

    /**
     * If the image is being used by any of your services
     *
     * @var bool
     */
    protected $in_use;

    /**
     * Resource URI of the registry where this image is hosted
     *
     * @var string
     */
    protected $registry;

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
     * @return boolean
     */
    public function isInUse()
    {
        return $this->in_use;
    }

    /**
     * @param boolean $in_use
     *
     * @return $this
     */
    public function setInUse($in_use)
    {
        $this->in_use = $in_use;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param string $registry
     *
     * @return $this
     */
    public function setRegistry($registry)
    {
        $this->registry = $registry;

        return $this;
    }

}