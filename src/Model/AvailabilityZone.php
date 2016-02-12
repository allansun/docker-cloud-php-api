<?php


namespace DockerCloud\Model;

class AvailabilityZone extends AbstractInfrastructrueModel
{

    /**
     * Whether the availability zone is currently available for new node deployments
     *
     * @var bool
     */
    protected $available;

    /**
     * An identifier for the availability zone
     *
     * @var string
     */
    protected $name;


    /**
     * The resource URI of the region where the availability zone is allocated
     *
     * @var string
     */
    protected $region;

    /**
     * A unique API endpoint that represents the region
     *
     * @var string
     */
    protected $resource_uri;

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
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     *
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;

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

}