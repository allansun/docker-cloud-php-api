<?php


namespace DockerCloud\Model;


class Stack extends AbstractApplicationModel
{
    const STATE_NOT_RUNNING = 'Not Running';
    const STATE_STARTING = 'Starting';
    const STATE_RUNNING = 'Running';
    const STATE_PARTLY_RUNNING = 'Partly running';
    const STATE_STOPPING = 'Stopping';
    const STATE_STOPPED = 'Stopped';
    const STATE_REDEPLOYING = 'Redeploying';
    const STATE_TERMINATING = 'Terminating';
    const STATE_TERMINATED = 'Terminated';

    /**
     * A unique identifier for the stack generated automatically on creation
     *
     * @var string
     */
    protected $uuid;

    /**
     * A unique API endpoint that represents the stack
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * A user provided name for the stack.
     *
     * @var string
     */
    protected $name;

    /**
     * The state of the stack (See const STATE_*)
     *
     * @var string
     */
    protected $state;

    /**
     * Flag indicating if the current stack definition is synchronized with their services.
     *
     * @var bool
     */
    protected $synchronized;

    /**
     * List of service resource URIs belonging to the stack
     *
     * @var string[]
     */
    protected $services=[];

    /**
     * The date and time of the last deployment of the stack (if applicable, null otherwise)
     *
     * @var string|null
     */
    protected $deployed_datetime = null;

    /**
     * The date and time of the terminate operation on the stack (if applicable, null otherwise)
     *
     * @var string|null
     */
    protected $destroyed_datetime = null;

    /**
     * A user-friendly name for the stack ($name by default)
     *
     * @var string
     */
    protected $nickname;

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

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
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSynchronized()
    {
        return $this->synchronized;
    }

    /**
     * @param boolean $synchronized
     *
     * @return $this
     */
    public function setSynchronized($synchronized)
    {
        $this->synchronized = $synchronized;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param \string[] $services
     *
     * @return $this
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDeployedDatetime()
    {
        return $this->deployed_datetime;
    }

    /**
     * @param null|string $deployed_datetime
     *
     * @return $this
     */
    public function setDeployedDatetime($deployed_datetime)
    {
        $this->deployed_datetime = $deployed_datetime;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDestroyedDatetime()
    {
        return $this->destroyed_datetime;
    }

    /**
     * @param null|string $destroyed_datetime
     *
     * @return $this
     */
    public function setDestroyedDatetime($destroyed_datetime)
    {
        $this->destroyed_datetime = $destroyed_datetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     *
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }


}