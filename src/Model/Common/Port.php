<?php


namespace DockerCloud\Model\Common;


use DockerCloud\Model\AbstractModel;

class Port extends AbstractModel
{
    const PROTOCOL_TCP = 'tcp';
    const PROTOCOL_UDP = 'udp';

    /**
     * The protocol of the port, either tcp or udp
     *
     * @var string
     */
    protected $protocol;

    /**
     * The published port number inside the container
     *
     * @var int
     */
    protected $inner_port;

    /**
     * The published port number in the node public network interface
     *
     * @var int
     */
    protected $outer_port;

    /**
     * Name of the service associated to this port
     *
     * @var string
     */
    protected $port_name;

    /**
     * The URI of the service endpoint for this port
     *
     * @var string
     */
    protected $endpoint_uri;

    /**
     * Whether the port has been published in the host public network interface or not.
     * Non-published ports can only be accessed via links.
     *
     * @var bool
     */
    protected $published;

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     *
     * @return $this
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @return int
     */
    public function getInnerPort()
    {
        return $this->inner_port;
    }

    /**
     * @param int $inner_port
     *
     * @return $this
     */
    public function setInnerPort($inner_port)
    {
        $this->inner_port = $inner_port;

        return $this;
    }

    /**
     * @return int
     */
    public function getOuterPort()
    {
        return $this->outer_port;
    }

    /**
     * @param int $outer_port
     *
     * @return $this
     */
    public function setOuterPort($outer_port)
    {
        $this->outer_port = $outer_port;

        return $this;
    }

    /**
     * @return string
     */
    public function getPortName()
    {
        return $this->port_name;
    }

    /**
     * @param string $port_name
     *
     * @return $this
     */
    public function setPortName($port_name)
    {
        $this->port_name = $port_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndpointUri()
    {
        return $this->endpoint_uri;
    }

    /**
     * @param string $endpoint_uri
     *
     * @return $this
     */
    public function setEndpointUri($endpoint_uri)
    {
        $this->endpoint_uri = $endpoint_uri;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param boolean $published
     *
     * @return $this
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @param      $outerPort
     * @param null $innerPort
     * @param null $isPublished
     *
     * @return static
     */
    static public function build($innerPort = null, $outerPort = null, $isPublished = null)
    {
        $Port = new static();
        $Port->setOuterPort($outerPort);
        $Port->setInnerPort($innerPort);
        $Port->setPublished($isPublished);

        return $Port;
    }
}