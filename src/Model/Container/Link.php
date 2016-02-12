<?php


namespace DockerCloud\Model\Container;


use DockerCloud\Model\AbstractModel;

class Link extends AbstractModel
{
    /**
     * The name given to the link
     *
     * @var string
     */
    protected $name;

    /**
     * The resource URI of the “client” container
     *
     * @var string
     */
    protected $from_container;

    /**
     * The resource URI of the “server” container being linked
     *
     * @var string
     */
    protected $to_container;

    /**
     * A dictionary with the endpoints (protocol, IP and port) to be used
     * to reach each of the “server” container exposed ports
     *
     * @var \ArrayObject
     */
    protected $endpoints;

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
    public function getFromContainer()
    {
        return $this->from_container;
    }

    /**
     * @param string $from_container
     *
     * @return $this
     */
    public function setFromContainer($from_container)
    {
        $this->from_container = $from_container;

        return $this;
    }

    /**
     * @return string
     */
    public function getToContainer()
    {
        return $this->to_container;
    }

    /**
     * @param string $to_container
     *
     * @return $this
     */
    public function setToContainer($to_container)
    {
        $this->to_container = $to_container;

        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * @param \ArrayObject $endpoints
     *
     * @return $this
     */
    public function setEndpoints($endpoints)
    {
        $this->endpoints = $endpoints;

        return $this;
    }


}