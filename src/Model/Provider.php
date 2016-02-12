<?php


namespace DockerCloud\Model;


class Provider extends AbstractInfrastructrueModel
{
    /**
     * A unique API endpoint that represents the provider
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * A unique identifier for the provider
     *
     * @var string
     */
    protected $name;

    /**
     * A user-friendly name for the provider
     *
     * @var string
     */
    protected $label;

    /**
     * A list of resource URIs of the regions available in this provider
     *
     * @var string[]
     */
    protected $regions;

    /**
     * Whether the provider is currently available for new node deployments
     *
     * @var bool
     */
    protected $available;

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
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @param \string[] $regions
     *
     * @return $this
     */
    public function setRegions($regions)
    {
        $this->regions = $regions;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAvailable()
    {
        return $this->available;
    }

    /**
     * @param boolean $available
     *
     * @return $this
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

}