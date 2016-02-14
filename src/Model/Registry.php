<?php


namespace DockerCloud\Model;



class Registry extends AbstractRepoModel
{
    /**
     * A unique API endpoint that represents the registry
     *
     * @var string
     */
    protected $resource_uri;
    /**
     * Human-readable name of the registry
     *
     * @var string
     */
    protected $name;
    /**
     * FQDN of the registry, i.e. registry-1.docker.io
     *
     * @var string
     */
    protected $host;
    /**
     * Whether this registry is run by Docker
     *
     * @var bool
     */
    protected $is_docker_registry;
    /**
     * Whether this registry has SSL activated or not
     *
     * @var bool
     */
    protected $is_ssl;
    /**
     * The port number where the registry is listening to
     *
     * @var int
     */
    protected $port;

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
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsDockerRegistry()
    {
        return $this->is_docker_registry;
    }

    /**
     * @param boolean $is_docker_registry
     *
     * @return $this
     */
    public function setIsDockerRegistry($is_docker_registry)
    {
        $this->is_docker_registry = $is_docker_registry;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsSsl()
    {
        return $this->is_ssl;
    }

    /**
     * @param boolean $is_ssl
     *
     * @return $this
     */
    public function setIsSsl($is_ssl)
    {
        $this->is_ssl = $is_ssl;

        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     *
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }
}