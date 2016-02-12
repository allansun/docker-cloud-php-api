<?php


namespace DockerCloud\Model;


class NodeType extends AbstractInfrastructrueModel
{
    /**
     * A unique API endpoint that represents the node type
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * An identifier for the node type
     *
     * @var string
     */
    protected $name;

    /**
     * A user-friendly name for the node type
     *
     * @var string
     */
    protected $label;

    /**
     * A list of resource URIs of the regions to which this node type can be deployed to
     *
     * @var string[]
     */
    protected $regions;

    /**
     * A list of resource URIs of the availability zones to which this node type can be deployed to
     *
     * @var string[]
     */
    protected $availability_zones;

    /**
     * The resource URI of the provider of the node type
     *
     * @var string
     */
    protected $provider;

    /**
     * Whether the node type is currently available for new node deployments
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
     * @return \string[]
     */
    public function getAvailabilityZones()
    {
        return $this->availability_zones;
    }

    /**
     * @param \string[] $availability_zones
     *
     * @return $this
     */
    public function setAvailabilityZones($availability_zones)
    {
        $this->availability_zones = $availability_zones;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param string $provider
     *
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

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